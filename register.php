<?php
session_start();

$errors = [];
$name = $email = $url = $password = $confirm_password = $phone = $gender = $country = $skills = $biography = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // PHP validation logic remains the same
    if (isset($_POST["name"]) && $_POST["name"] !== "") {
        $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors['name'] = "Only letters and spaces allowed.";
        }
    } else {
        $errors['name'] = "Name is required.";
    }

    // Email validation
    if (isset($_POST["email"]) && $_POST["email"] !== "") {
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
    } else {
        $errors['email'] = "Email is required.";
    }

    // Facebook URL validation
    if (isset($_POST["url"]) && $_POST["url"] !== "") {
        $url = filter_var(trim($_POST["url"]), FILTER_SANITIZE_URL);
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $errors['url'] = "Invalid URL.";
        }
    } else {
        $errors['url'] = "Facebook URL is required.";
    }

    // Password validation
    if (isset($_POST["password"]) && $_POST["password"] !== "") {
        $password = trim($_POST["password"]);
        if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
            $errors['password'] = "Password must be at least 8 characters with 1 uppercase letter, 1 number, and 1 special character.";
        }
    } else {
        $errors['password'] = "Password is required.";
    }

    // Confirm password validation
    if (isset($_POST["confirm_password"]) && $_POST["confirm_password"] !== "") {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password !== $confirm_password) {
            $errors['confirm_password'] = "Passwords do not match.";
        }
    } else {
        $errors['confirm_password'] = "Confirm password is required.";
    }

    // Phone number validation
    if (isset($_POST["phone"]) && $_POST["phone"] !== "") {
        $phone = trim($_POST["phone"]);
        if (!preg_match("/^[0-9]+$/", $phone)) {
            $errors['phone'] = "Invalid phone number.";
        }
    } else {
        $errors['phone'] = "Phone number is required.";
    }

    // Gender validation
    if (!isset($_POST["gender"])) {
        $errors['gender'] = "Gender is required.";
    }

    // Country validation
    if (!isset($_POST["country"]) || $_POST["country"] === "") {
        $errors['country'] = "Country is required.";
    }

    // Skills validation
    if (isset($_POST["skills"])) {
        $skills = $_POST["skills"]; // Now it's guaranteed to be an array
    } else {
        $skills = []; // If no skills are selected, initialize it as an empty array
        $errors['skills'] = "Please select at least one skill.";
    }

    // Biography validation
    if (isset($_POST["biography"]) && $_POST["biography"] !== "") {
        $biography = filter_var(trim($_POST["biography"]), FILTER_SANITIZE_STRING);
        if (mb_strlen($biography) > 200) {
            $errors['biography'] = "Biography must not exceed 200 characters.";
        }
    } else {
        $errors['biography'] = "Biography is required.";
    }

    // If no errors, save to session and redirect
    if (count($errors) == 0) {
        $_SESSION['user'] = [
            'name' => $name,
            'email' => $email,
            'url' => $url,
            'password' => $password,
            'phone' => $phone,
            'gender' => $_POST['gender'],
            'country' => $_POST['country'],
            'skills' => $_POST['skills'],
            'biography' => $biography
        ];
        header('Location: about.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            max-width: 50%;
            margin: auto;
            margin-top: 50px;
        }
        @media (max-width: 768px) {
            .card {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center">Register</h2>
            <form method="post" action="register.php">
                <!-- Name Field -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                    <small class="text-danger"><?php echo $errors['name'] ?? ''; ?></small>
                </div>

                <!-- Email Field -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <small class="text-danger"><?php echo $errors['email'] ?? ''; ?></small>
                </div>

                <!-- Facebook URL Field -->
                <div class="mb-3">
                    <label for="url" class="form-label">Facebook URL</label>
                    <input type="text" class="form-control" id="url" name="url" value="<?php echo htmlspecialchars($url); ?>">
                    <small class="text-danger"><?php echo $errors['url'] ?? ''; ?></small>
                </div>

                <!-- Password Field -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="text-danger"><?php echo $errors['password'] ?? ''; ?></small>
                </div>

                <!-- Confirm Password Field -->
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <small class="text-danger"><?php echo $errors['confirm_password'] ?? ''; ?></small>
                </div>

                <!-- Phone Number Field -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <small class="text-danger"><?php echo $errors['phone'] ?? ''; ?></small>
                </div>

                <!-- Gender Radio Buttons -->
                <div class="mb-3">
                    <label class="form-label">Gender</label><br>
                    <input type="radio" name="gender" value="male" <?php echo isset($gender) && $gender == 'male' ? 'checked' : ''; ?>> Male
                    <input type="radio" name="gender" value="female" <?php echo isset($gender) && $gender == 'female' ? 'checked' : ''; ?>> Female
                    <small class="text-danger"><?php echo $errors['gender'] ?? ''; ?></small>
                </div>

                <!-- Country Dropdown -->
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-select" id="country" name="country">
                        <option value="">Select</option>
                        <option value="USA" <?php echo isset($country) && $country == 'USA' ? 'selected' : ''; ?>>USA</option>
                        <option value="Canada" <?php echo isset($country) && $country == 'Canada' ? 'selected' : ''; ?>>Canada</option>
                        <option value="Philippines" <?php echo isset($country) && $country == 'Philippines' ? 'selected' : ''; ?>>Philippines</option>
                    </select>
                    <small class="text-danger"><?php echo $errors['country'] ?? ''; ?></small>
                </div>

                <!-- Skills Checkboxes -->
                <div class="mb-3">
                    <label class="form-label">Skills</label><br>
                    <input type="checkbox" name="skills[]" value="HTML" <?php echo is_array($skills) && in_array('HTML', $skills) ? 'checked' : ''; ?>> HTML
                    <input type="checkbox" name="skills[]" value="CSS" <?php echo is_array($skills) && in_array('CSS', $skills) ? 'checked' : ''; ?>> CSS
                    <input type="checkbox" name="skills[]" value="PHP" <?php echo is_array($skills) && in_array('PHP', $skills) ? 'checked' : ''; ?>> PHP
                    <small class="text-danger"><?php echo $errors['skills'] ?? ''; ?></small>
                </div>

                <!-- Biography Field -->
                <div class="mb-3">
                    <label for="biography" class="form-label">Biography</label>
                    <textarea class="form-control" id="biography" name="biography" maxlength="200"><?php echo htmlspecialchars($biography); ?></textarea>
                    <small class="text-danger"><?php echo $errors['biography'] ?? ''; ?></small>
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
