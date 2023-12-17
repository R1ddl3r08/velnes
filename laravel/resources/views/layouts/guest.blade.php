<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/main.css'])
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
</head>
<body>
    <div class="auth-bg">
        <div class="form-container">
           @yield('form')
        </div>
        @yield('message')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script>
        const password = document.getElementById('password');
        const passwordRequirements = document.getElementById('password-requirements');
        
        const assetBaseUrl = "{{ asset('') }}"

        function checkPasswordStrength(password) {
            const requirementLabels = {
                length: 'Minimum 8 characters',
                hasNumber: 'Contains at least one number',
                hasSpecialCharacter: 'Contains at least one special character',
                hasUppercase: 'Contains at least one uppercase letter',
                hasLowercase: 'Contains at least one lowercase letter',
            };

            const requirementsMet = {
                length: password.length >= 8,
                hasNumber: /[0-9]/.test(password),
                hasSpecialCharacter: /[!@#$%^&*]/.test(password),
                hasUppercase: /[A-Z]/.test(password),
                hasLowercase: /[a-z]/.test(password),
            };

            passwordRequirements.innerHTML = '';

            for (const [requirement, isMet] of Object.entries(requirementsMet)) {
                const iconSrc = isMet ? `${assetBaseUrl}svg/check.svg` : `${assetBaseUrl}svg/x.svg`;
                const label = requirementLabels[requirement];
                passwordRequirements.innerHTML += `<div class="requirement"> ${label} <img src="${iconSrc}" alt="${isMet ? '✓' : '✗'}" /></div>`;
            }
        }

        password.addEventListener('input', function () {
            const passwordInput = password.value;
            checkPasswordStrength(passwordInput);
            passwordRequirements.style.display = 'block';
        });

        password.addEventListener('blur', function () {
            passwordRequirements.style.display = 'none';blur
        });

        checkPasswordStrength(password.value);
    </script>


    @yield('scripts')
</body>
</html>
