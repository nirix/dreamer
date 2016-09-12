import AppDispatcher from './app-dispatcher';
import {EventEmitter} from 'events';

const EVENTS = {
    loggedin: 'USER-LOGGEDIN',
    loggedout: 'USER-LOGGEDOUT',
    change: 'USER-CHANGE'
};

class SessionStore extends EventEmitter {
    constructor() {
        super();

        this.currentUser = null;

        this.dispatcherIndex = AppDispatcher.register(function(payload) {
            var action = payload.action;

            console.log('app-dispatcher.register', payload, action);

            return true;
        });
    }

    login(user) {
        this.setCurrentUser(user);
        this.emit(EVENTS.loggedin);
    }

    logout() {
        this.setCurrentUser(null);
        this.emit(EVENTS.loggedout);
    }

    setCurrentUser(user) {
        this.currentUser = user;
        this.emit(EVENTS.change);
    }

    getCurrentUser() {
        return this.currentUser;
    }

    addLoginListener(callback) {
        this.on(EVENTS.loggedin, callback);
    }

    addLogoutListener(callback) {
        this.on(EVENTS.loggedout, callback);
    }

    addChangeListener(callback) {
        this.on(EVENTS.change, callback);
    }

    removeLoginListener(callback) {
        this.removeListener(EVENTS.loggedin, callback);
    }

    removeLogoutListener(callback) {
        this.removeListener(EVENTS.loggedout, callback);
    }

    removeChangeListener(callback) {
        this.removeListener(EVENTS.change, callback);
    }
}

const store = new SessionStore();

module.exports = store;
