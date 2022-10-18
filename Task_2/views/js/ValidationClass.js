export class ValidationClass {

    checkName(name) {
        if (name.length === 0)
            return false;

        return name.match(/^([а-яА-яa-zA-z]+\s)+([а-яА-яa-zA-z])+$/ig) !== null;
    }

    checkEmail(email) {
        return !(email.length === 0 || email.length < 5);
    }

    checkStatus(status) {
        return status !== 'status';

    }

    checkGender(gender) {
        return gender !== 'gender';
    }
}

