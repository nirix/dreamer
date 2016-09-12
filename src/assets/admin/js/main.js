import React from 'react';
import {render} from 'react-dom';
import {Router, Route, IndexRoute, useRouterHistory} from 'react-router';
import createBrowserHistory from 'history/lib/createBrowserHistory';

import {Header} from './layout';
import {Articles} from './articles';
import {Login, Register} from './users';
import SessionStore from './session-store';

const appHistory = useRouterHistory(createBrowserHistory)({
    basename: window.baseUrl,
    queryKey: false
});

class Dreamer extends React.Component {
    constructor() {
        super();

        this.state = {
            currentUser: null
        }

        this.setCurrentUser = this.setCurrentUser.bind(this);

        SessionStore.addChangeListener(this.setCurrentUser);
    }

    setCurrentUser() {
        this.setState({ currentUser: SessionStore.getCurrentUser() });
    }

    render() {
        return (
            <div>
                <Header currentUser={this.state.currentUser} />
                <main>
                    {this.props.children && React.cloneElement(this.props.children, { currentUser: this.state.currentUser })}
                </main>
                <footer>
                    <div className="container">
                        &copy; 2014-2016
                    </div>
                </footer>
            </div>
        );
    }
}

render((
<Router history={appHistory}>
    <Route name="root" path="/admin" component={Dreamer}>
        <IndexRoute component={Articles} />
        <Route name="login" path="/admin/login" component={Login} />
        <Route name="register" path="/admin/register" component={Register} />
    </Route>
</Router>
), document.getElementById('dreamer'));
