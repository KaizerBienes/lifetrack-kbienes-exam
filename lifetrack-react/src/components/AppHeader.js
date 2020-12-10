import './_AppHeader.scss';
import React, { Component } from 'react';

class AppHeader extends Component {
    render() {
        return (
            <div className="AppHeader">
                <h1>LifeTrack Study Tracker</h1>
                <h4>Cost per month estimates</h4>
            </div>
        );
    }
}

export default AppHeader;