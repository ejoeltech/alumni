<?php
class PaymentsController extends Controller
{
    public function __construct()
    {
        // Enforce Authentication
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function index()
    {
        $paymentModel = $this->model('Payment');

        // Fetch all platform active network dues
        $allDues = $paymentModel->getAllDues();

        // Fetch this specific user's raw payment ledger history
        $myPayments = $paymentModel->getPaymentsByUser($_SESSION['user_id']);

        $data = [
            'title' => 'My Financials',
            'dues' => $allDues,
            'my_payments' => $myPayments
        ];

        $this->view('payments/index', $data);
    }

    public function submit($due_id = null)
    {
        $paymentModel = $this->model('Payment');

        $data = [
            'title' => 'Submit Payment Log',
            'due_id' => $due_id,
            'amount' => '',
            'payment_date' => date('Y-m-d'),
            'payment_method' => 'Bank Transfer',
            'reference_number' => '',
            'error' => '',
            'success' => ''
        ];

        // If a specific due was passed, try to prefill the amount
        if ($due_id) {
            $due = $paymentModel->getDueById($due_id);
            if ($due) {
                $data['amount'] = $due['amount'];
                $data['due_title'] = $due['title'];
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['amount'] = trim(htmlspecialchars($_POST['amount']));
            $data['payment_date'] = trim(htmlspecialchars($_POST['payment_date']));
            $data['payment_method'] = trim(htmlspecialchars($_POST['payment_method']));
            $data['reference_number'] = trim(htmlspecialchars($_POST['reference_number']));
            $data['due_id'] = !empty($_POST['due_id']) ? $_POST['due_id'] : null;

            if (empty($data['amount']) || empty($data['payment_date']) || empty($data['payment_method'])) {
                $data['error'] = 'Amount, Date, and Method are required fields.';
            } else {
                $paymentData = [
                    'user_id' => $_SESSION['user_id'],
                    'due_id' => $data['due_id'],
                    'amount' => $data['amount'],
                    'payment_date' => $data['payment_date'],
                    'payment_method' => $data['payment_method'],
                    'reference_number' => $data['reference_number'],
                    'status' => 'Pending' // Initial status is always pending until admin verifies
                ];

                if ($paymentModel->createPayment($paymentData)) {
                    $data['success'] = 'Payment logged successfully. It is now Pending manual verification by the platform administration.';
                    $data['amount'] = ''; // Clear form
                    $data['reference_number'] = '';
                } else {
                    $data['error'] = 'Database error logging payment.';
                }
            }
        }

        // Fetch dues again to populate dropdown if no specific due_id
        $data['all_dues'] = $paymentModel->getAllDues();

        $this->view('payments/submit', $data);
    }
}
