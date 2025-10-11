<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Google Fonts (Poppins) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
</style>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="card p-4 p-md-5 shadow-lg border-0 rounded-4" style="max-width: 450px; width: 100%;">
        
        <div class="text-center mb-4">
            <i class="bi bi-shield-check display-3 text-primary"></i>
            <h3 class="fw-bold mt-3 mb-2">OTP Verification</h3>
            <p class="text-muted">Enter the 6-digit code sent to your email.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div>{{ session('status') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="otp" class="form-label visually-hidden">OTP Code</label>
                <input type="text" 
                       name="otp" 
                       id="otp"
                       class="form-control form-control-lg text-center fw-bold fs-4 @error('otp') is-invalid @enderror" 
                       required 
                       autofocus
                       maxlength="6"
                       autocomplete="one-time-code"
                       placeholder="------"
                       inputmode="numeric"
                       pattern="\d{6}">
                
                @error('otp')
                    <div class="invalid-feedback text-center mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg fw-semibold">Verify & Continue</button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-muted mb-2">Didn't receive the code?</p>
            <form method="POST" action="{{ route('otp.resend') }}">
                @csrf
                <button type="submit" class="btn btn-link fw-bold text-decoration-none">Resend</button>
            </form>
        </div>

    </div>
</div>
