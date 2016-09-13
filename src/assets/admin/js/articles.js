import React from 'react';
import SessionStore from './session-store';

class Articles extends React.Component {
    constructor() {
        super();

        this.goAway = this.goAway.bind(this);
    }

    goAway() {
        if (!SessionStore.getCurrentUser()) {
            this.context.router.push('/admin/login');
        }
    }

    componentWillMount() {
        if (this.props.currentUser === false) {
            this.goAway();
        }

        SessionStore.addLogoutListener(this.goAway);
    }

    componentWillUnmount() {
        SessionStore.removeLogoutListener(this.goAway);
    }

    render() {
        return (
            <div className="container">
                <h1 className="page-header">Articles</h1>
            </div>
        );
    }
}

Articles.contextTypes = {
    router: React.PropTypes.object.isRequired
}

module.exports = {
    Articles: Articles
};
