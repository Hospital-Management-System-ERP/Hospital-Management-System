<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Buttons Demo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Submit button hover effect */
        .btn-primary {
            transition: 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        /* Reset button hover */
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow p-4">
        <h4 class="mb-4">Doctor Registration Form</h4>

        <form>

            <!-- Example Field -->
            <div class="mb-3">
                <label class="form-label">
                    Password 
                    <small class="text-muted">(Minimum 6 Characters)</small>
                    <span class="text-danger">*</span>
                </label>
                <input type="password" class="form-control" minlength="6" required>
            </div>

            <!-- Buttons -->
            <div class="d-flex flex-column flex-md-row gap-3 mt-4">

                <!-- Reset Button -->
                <button type="reset" 
                        class="btn btn-outline-secondary w-100 w-md-auto px-4 py-2 fw-semibold">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                    Reset
                </button>

                <!-- Submit Button -->
                <button type="submit" 
                        class="btn btn-primary w-100 w-md-auto px-4 py-2 fw-semibold">
                    <i class="bi bi-check-circle me-2"></i>
                    Submit
                </button>

            </div>

        </form>
    </div>
</div>

</body>
</html>