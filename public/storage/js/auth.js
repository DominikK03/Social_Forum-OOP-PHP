class Auth {
    static init() {
        this.cacheDOM();
        this.bindEvents();
    }

    static cacheDOM() {
        this.$loginForm = $('#loginForm');
        this.$loginName = $('#name');
        this.$loginPassword = $('#password');
        this.$loginInvalidFeedback = $('.invalid-feedback');

        this.$registrationForm = $('#registrationForm');
        this.$registerName = $('#name');
        this.$registerEmail = $('#email');
        this.$registerPassword = $('#password');
        this.$registerConfirmPassword = $('#confirmPassword');
        this.$registerButton = $('.register-btn');
        this.$emailExistFeedback = $('.email-exist');
        this.$usernameExistFeedback = $('.username-exist');
    }

    static bindEvents() {
        this.$loginForm.on('submit', (e) => {
            e.preventDefault();
            this.submitLogin();
        });

        this.$registerEmail.on('input', () => this.validateEmailInput());
        this.$registerPassword.on('input', () => this.validatePasswordInput());
        this.$registerConfirmPassword.on('input', () => this.validateConfirmPasswordInput());
        this.$registrationForm.on('submit', (e) => {
            e.preventDefault();
            this.submitRegistration();
        });
    }

    // Helper Validation Functions
    static validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(String(email).toLowerCase());
    }

    static validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return re.test(password);
    }

    static confirmPassword(password, confirmPassword) {
        return password === confirmPassword;
    }

    static checkFormValidity() {
        const emailValid = this.validateEmail(this.$registerEmail.val());
        const passwordValid = this.validatePassword(this.$registerPassword.val());
        const confirmPasswordValid = this.confirmPassword(this.$registerPassword.val(), this.$registerConfirmPassword.val());

        this.$registerButton.prop('disabled', !(emailValid && passwordValid && confirmPasswordValid));
    }

    static validateEmailInput() {
        const email = this.$registerEmail.val();
        if (this.validateEmail(email)) {
            this.$registerEmail.removeClass('is-invalid').addClass('is-valid');
            this.$registerEmail.next('.invalid-feedback').hide();
        } else {
            this.$registerEmail.removeClass('is-valid').addClass('is-invalid');
            this.$registerEmail.next('.invalid-feedback').show();
        }
        this.checkFormValidity();
    }

    static validatePasswordInput() {
        const password = this.$registerPassword.val();
        if (this.validatePassword(password)) {
            this.$registerPassword.removeClass('is-invalid').addClass('is-valid');
            this.$registerPassword.next('.invalid-feedback').hide();
        } else {
            this.$registerPassword.removeClass('is-valid').addClass('is-invalid');
            this.$registerPassword.next('.invalid-feedback').show();
        }
        this.checkFormValidity();
    }

    static validateConfirmPasswordInput() {
        const confirmPasswordVal = this.$registerConfirmPassword.val();
        if (this.confirmPassword(this.$registerPassword.val(), confirmPasswordVal)) {
            this.$registerConfirmPassword.removeClass('is-invalid').addClass('is-valid');
            this.$registerConfirmPassword.next('.invalid-feedback').hide();
        } else {
            this.$registerConfirmPassword.removeClass('is-valid').addClass('is-invalid');
            this.$registerConfirmPassword.next('.invalid-feedback').show();
        }
        this.checkFormValidity();
    }

    static submitLogin() {
        const formData = {
            name: this.$loginName.val(),
            password: this.$loginPassword.val()
        };

        $.ajax({
            type: 'POST',
            url: '/login',
            data: formData,
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    sessionStorage.setItem('userRole', response.role);
                    location.href = '/';
                } else {
                    this.$loginInvalidFeedback.show().delay(3000).fadeOut();
                }
            },
            error: (xhr) => {
                console.error(xhr.responseText);
            }
        });
    }

    // Registration Form Submission
    static submitRegistration() {
        this.$emailExistFeedback.hide();
        this.$usernameExistFeedback.hide();

        const formData = {
            name: this.$registerName.val(),
            email: this.$registerEmail.val(),
            password: this.$registerPassword.val(),
            confirmPassword: this.$registerConfirmPassword.val()
        };

        $.ajax({
            type: 'POST',
            url: '/register',
            data: formData,
            dataType: 'json',
            success: (response) => {
                if (response.success) {
                    window.location.href = '/login';
                } else {
                    if (response.message === "Username already exists") {
                        this.$usernameExistFeedback.show();
                    } else if (response.message === "E-mail already exists") {
                        this.$emailExistFeedback.show();
                    }
                }
            },
            error: (xhr) => {
                console.error(xhr.responseText);
            }
        });
    }
}

$(document).ready(() => Auth.init());
