export default class Gate {

    constructor(user) {
        this.user = user;
    }

    isAdmin() {
        return this.user.type === 'admin';

    }
    isUser() {
        return this.user.type === 'user';

    }
    isAuthor() {
        return this.user.type === 'author';

    }
    isSupply() {
        return this.user.type === 'supply';

    }
    isEmployee() {
        return this.user.type === 'employee';
    }
    isAuditor() {
        return this.user.type === 'auditor';

    }
    isEmployeeOrSupply() {
        if (this.user.type === 'employee' || this.user.type === 'supply') {
            return true;
        }
    }
    isAdminOrAuthor() {
        if (this.user.type === 'admin' || this.user.type === 'author') {
            return true;
        }
    }
    isUserOrAuthor() {
        if (this.user.type === 'user' || this.user.type === 'author') {
            return true;
        }
    }
    isAdminOrUserOrAuthor() {
        if (this.user.type === 'admin' || this.user.type === 'user' || this.user.type === 'author') {
            return true;
        }
    }
    isAdminOrUserOrAuthorOrEmployee() {
        if (this.user.type === 'admin' || this.user.type === 'user' || this.user.type === 'author' || this.user.type === 'employee') {
            return true;
        }
    }
    isAllExceptEmployee() {
        if (this.user.type === 'admin' || this.user.type === 'user' || this.user.type === 'author' || this.user.type === 'supply') {
            return true;
        }
    }
    isAdminOrUserOrAuthorOrEmployeeOrSupply() {
        if (this.user.type === 'admin' || this.user.type === 'user' || this.user.type === 'author' || this.user.type === 'employee' || this.user.type === 'supply') {
            return true;
        }
    }

}

// Dont forget to register it to the policies 
// like what the hell I didn't register and make it as 
// a problem for more than 2days including the nighmare