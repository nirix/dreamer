import React from 'react';

class Articles extends React.Component {
    componentWillMount() {
        if (!this.props.currentUser) {
            this.context.router.push('/admin/login');
        }
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
