<div class="row w-100">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2>Log In</h2>
            <p>Please fill in your credentials to log in.</p>
            <form action="/doncosa/public/auth/login" method="post">
                <div class="form-group mb-3">
                    <label for="email">Email or Phone Number: <sup>*</sup></label>
                    <input type="text" name="email"
                        class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['email']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['email_err']; ?>
                    </span>
                </div>
                <div class="form-group mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="mb-0">Password: <sup>*</sup></label>
                        <a href="/doncosa/public/auth/recover" class="small text-muted text-decoration-none">Forgot
                            Password?</a>
                    </div>
                    <input type="password" name="password"
                        class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['password']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['password_err']; ?>
                    </span>
                </div>

                <div class="row mt-4">
                    <div class="col d-grid">
                        <input type="submit" value="Login" class="btn btn-primary shadow-sm btn-block">
                    </div>
                    <div class="col d-grid">
                        <a href="/doncosa/public/auth/register" class="btn btn-outline-secondary btn-block">No account?
                            Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>