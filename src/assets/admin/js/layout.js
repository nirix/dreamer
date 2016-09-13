import React from 'react';
import {Link} from 'react-router';
import SessionStore from './session-store';

class Header extends React.Component {
    render() {
        return (
            <div>
                <nav className="navbar navbar-default navbar-static-top">
                    <div className="container">
                        <div className="navbar-header">
                            <Link to="/admin" className="navbar-brand">Dreamer</Link>
                        </div>

                        <div className="navbar-collapse">
                            <div className="navbar-right">
                                <UserNav currentUser={this.props.currentUser} />
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        );
    }
}

class UserNav extends React.Component {
    constructor() {
        super();

        this.logout = this.logout.bind(this);
    }

    logout(event) {
        event.preventDefault();
        SessionStore.logout();
    }

    render() {
        if (this.props.currentUser) {
            return (
                <ul className="nav navbar-nav">
                    <li>
                        <a href="#" onClick={this.logout}>Logout</a>
                    </li>
                </ul>
            );
        } else {
            return (
                <ul className="nav navbar-nav">
                    <NavLink to="/admin/login">Login</NavLink>
                    <NavLink to="/admin/register">Register</NavLink>
                </ul>
            );
        }
    }
}

UserNav.contextTypes = {
    router: React.PropTypes.object.isRequired
}

class NavLink extends React.Component {
    render() {
        let className = this.context.router.isActive(this.props.to, true) ? 'active' : '';

        return (
            <li className={className}>
                <Link {...this.props}>
                    {this.props.children}
                </Link>
            </li>
        );
    }
}

class ErrorsAlert extends React.Component {
    render() {
        if (this.props.errors) {
            let errorNodes = this.props.errors.map(function(error, index) {
                return (
                    <li key={index}>
                        {error}
                    </li>
                );
            });

            return (
                <div className="alert alert-danger">
                    <ul>
                        {errorNodes}
                    </ul>
                </div>
            );
        } else {
            return null;
        }
    }
}

class FormErrorMessage extends React.Component {
    render() {
        if (this.props.message) {
            return (
                <p className="text-danger">{this.props.message}</p>
            );
        } else {
            return null;
        }
    }
}

NavLink.contextTypes = {
    router: React.PropTypes.object
};

module.exports = {
    Header: Header,
    UserNav: UserNav,
    NavLink: NavLink,
    ErrorsAlert: ErrorsAlert,
    FormErrorMessage: FormErrorMessage
}
