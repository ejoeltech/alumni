<div class="row w-100">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5 mb-5">
            <h2>Create An Account</h2>
            <p>Please fill out this form to register with the Alumni Platform.</p>
            <form action="/doncosa/public/auth/register" method="post">

                <div class="form-group mb-3">
                    <label for="full_name">Full Name: <sup>*</sup></label>
                    <input type="text" name="full_name"
                        class="form-control form-control-lg <?= (!empty($data['full_name_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['full_name']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['full_name_err']; ?>
                    </span>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email Address: <sup>*</sup></label>
                    <input type="email" name="email"
                        class="form-control form-control-lg <?= (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['email']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['email_err']; ?>
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="phone_number">Phone Number: <sup>*</sup></label>
                        <input type="text" name="phone_number"
                            class="form-control form-control-lg <?= (!empty($data['phone_number_err'])) ? 'is-invalid' : ''; ?>"
                            value="<?= isset($data['phone_number']) ? $data['phone_number'] : ''; ?>">
                        <span class="invalid-feedback">
                            <?= $data['phone_number_err'] ?? ''; ?>
                        </span>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="date_of_birth">Date of Birth: (Optional)</label>
                        <input type="date" name="date_of_birth" class="form-control form-control-lg"
                            value="<?= isset($data['date_of_birth']) ? $data['date_of_birth'] : ''; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="graduation_year">Graduation Year:</label>
                        <input type="text" name="graduation_year" class="form-control form-control-lg"
                            value="<?= isset($data['graduation_year']) ? $data['graduation_year'] : ''; ?>">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="class_set">Class Set:</label>
                        <input type="text" name="class_set" class="form-control form-control-lg"
                            value="<?= isset($data['class_set']) ? $data['class_set'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" name="password"
                        class="form-control form-control-lg <?= (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['password']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['password_err']; ?>
                    </span>
                </div>

                <div class="form-group mb-4">
                    <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                    <input type="password" name="confirm_password"
                        class="form-control form-control-lg <?= (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>"
                        value="<?= $data['confirm_password']; ?>">
                    <span class="invalid-feedback">
                        <?= $data['confirm_password_err']; ?>
                    </span>
                </div>

                <div class="row">
                    <div class="col d-grid">
                        <input type="submit" value="Register" class="btn btn-success btn-block">
                    </div>
                    <div class="col d-grid">
                        <a href="/doncosa/public/auth/login" class="btn btn-light btn-block">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>