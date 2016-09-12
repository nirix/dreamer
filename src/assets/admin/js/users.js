import React from 'react';
import {ErrorsAlert, FormErrorMessage} from './layout';
import AppDispatcher from './app-dispatcher';
import SessionStore from './session-store';

class Login extends React.Component {
    constructor() {
        super();

        this.state = {
            error: null
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.showError = this.showError.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();

        this.setState({ error: null });

        $.ajax({
            url: window.baseUrl + '/login',
            method: 'post',
            dataType: 'json',
            data: {
                username: event.target.getElementsByTagName('input')[0].value,
                password: event.target.getElementsByTagName('input')[1].value
            },
            cache: false,
            success: function(data){
                SessionStore.login(data);
                this.context.router.push('/admin');
            }.bind(this),
            error: function(xhr, status, error){
                if (xhr.status === 400) {
                    if (xhr.responseJSON.error.length > 0) {
                        this.setState({ error: [xhr.responseJSON.error] });
                    }
                } else {
                    console.error('error logging in', error.toString());
                }
            }.bind(this)
        });
    }

    showError() {
        if (this.state.error) {
            return (
                <div className="alert alert-danger">
                    {this.state.error}
                </div>
            );
        } else {
            return null;
        }
    }

    render() {
        return (
            <div className="container">
                <h1 className="page-header">Login</h1>

                <div className="row">
                    <div className="col-md-6 col-md-offset-3">
                        <form onSubmit={this.handleSubmit} method="post" className="form-horizontal">
                            {this.showError()}

                            <div className="form-group">
                                <label htmlFor="username" className="control-label col-sm-3">Username</label>
                                <div className="col-sm-9">
                                    <input type="text" name="username" id="username" className="form-control" />
                                </div>
                            </div>
                            <div className="form-group">
                                <label htmlFor="password" className="control-label col-sm-3">Password</label>
                                <div className="col-sm-9">
                                    <input type="password" name="password" id="password" className="form-control" />
                                </div>
                            </div>
                            <div className="form-actions">
                                <button type="submit" className="btn btn-default">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        );
    }
}

Login.contextTypes = {
    router: React.PropTypes.object.isRequired
}

class Register extends React.Component {
    constructor() {
        super();

        this.state = {
            errors: null
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.errorClass = this.errorClass.bind(this);
        this.errorMessage = this.errorMessage.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();

        $.ajax({
            url: window.baseUrl + '/users',
            method: 'post',
            dataType: 'json',
            data: {
                name: event.target.getElementsByTagName('input')[0].value,
                username: event.target.getElementsByTagName('input')[1].value,
                password: event.target.getElementsByTagName('input')[2].value,
                email: event.target.getElementsByTagName('input')[3].value
            },
            cache: false,
            success: function(data){
                this.context.router.push('/admin/login');
            }.bind(this),
            error: function(xhr, status, error){
                if (xhr.status == 400) {
                    if (xhr.responseJSON.errors) {
                        this.setState({ errors: xhr.responseJSON.errors });
                    }
                } else {
                    console.error('error logging in', error.toString());
                }
            }.bind(this)
        });
    }

    errorClass(field) {
        return (this.state.errors && this.state.errors.hasOwnProperty(field)) ? 'has-error' : '';
    }

    errorMessage(field) {
        return (this.state.errors && this.state.errors.hasOwnProperty(field)) ? this.state.errors[field][0] : '';
    }

    render() {
        return (
            <div className="container">
                <h1 className="page-header">Register</h1>

                <div className="row">
                    <div className="col-md-6 col-md-offset-3">
                        <form onSubmit={this.handleSubmit} method="post" className="form-horizontal">


                            <div className="form-group">
                                <label htmlFor="name" className="control-label col-md-3">Name</label>
                                <div className="col-md-9">
                                    <input type="text" name="name" id="name" className="form-control" />
                                </div>
                            </div>
                            <div className={`form-group ${this.errorClass('username')}`}>
                                <label htmlFor="username" className="control-label col-md-3">Username</label>
                                <div className="col-md-9">
                                    <input type="text" name="username" id="username" className="form-control" />
                                    <FormErrorMessage message={this.errorMessage('username')} />
                                </div>
                            </div>
                            <div className={`form-group ${this.errorClass('password')}`}>
                                <label htmlFor="password" className="control-label col-md-3">Password</label>
                                <div className="col-md-9">
                                    <input type="password" name="password" id="password" className="form-control" />
                                    <FormErrorMessage message={this.errorMessage('password')} />
                                </div>
                            </div>
                            <div className={`form-group ${this.errorClass('email')}`}>
                                <label htmlFor="email" className="control-label col-md-3">Email</label>
                                <div className="col-md-9">
                                    <input type="text" name="email" id="email" className="form-control" />
                                    <FormErrorMessage message={this.errorMessage('email')} />
                                </div>
                            </div>
                            <div className="form-actions">
                                <button type="submit" className="btn btn-default">Create Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        );
    }
}

Register.contextTypes = {
    router: React.PropTypes.object.isRequired
}

module.exports = {
    Login: Login,
    Register: Register
};
