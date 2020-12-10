import './_App.scss';
import AppHeader from './AppHeader';
import ChartForm from './ChartForm';
import ForecastTable from './ForecastTable';
import LineChart from './LineChart';

import React, { Component } from 'react';
import axios from 'axios';

class App extends Component {
    constructor(props) {
        super(props);
        this.modifyStudyResult = this.modifyStudyResult.bind(this);
        this.state = {
            numberOfStudyPerDay: 1,
            numberOfStudyGrowthPerMonth: 0.01,
            monthsToForecast: 1,
            resultSet: [],
            errorMessage: null
        };

    }

    modifyStudyResult(name, value) {
        let trimmedValue = value.toString().trim();
        if (trimmedValue !== null && trimmedValue !== '' && !isNaN(trimmedValue)) {
            this.setState({
                [name]: value,
                errorMessage: null
            }, () => {
                this.generateTable();
            });
        }
    }

    generateTable() {
        axios.get('http://localhost:8001/api/v0/study-tracker/calculate', {
            params: {
                spd: this.state.numberOfStudyPerDay,
                gpm: this.state.numberOfStudyGrowthPerMonth,
                mtf: this.state.monthsToForecast
            }
        }).then(res => {
            const forecastedData = res.data.data;
            this.setState({
                resultSet: forecastedData
            });
        }).catch(err => {
            if (err.response !== undefined && err.response.data.errors !== undefined) {
                this.setState({
                    errorMessage: Object.values(err.response.data.errors).map(str => <p>{str}</p>)
                })
            } else {
                this.setState({
                    errorMessage: err.errorMessage
                })
            }
        });
    }

    render() {
        return (
            <div className="App">
                <AppHeader />
                <div className="AppContent">
                    <ChartForm
                        numberOfStudyPerDay={this.state.numberOfStudyPerDay}
                        numberOfStudyGrowthPerMonth={this.state.numberOfStudyGrowthPerMonth}
                        monthsToForecast={this.state.monthsToForecast}
                        inputErrors={this.state.errorMessage}
                        onChangeFormValue={this.modifyStudyResult}
                    />
                    <ForecastTable resultSet={this.state.resultSet}/>
                </div>
                <div className="AppCharts">
                    <LineChart resultSet={this.state.resultSet} targetedResultSet="cost" title="Cost Per Month"/>
                    <LineChart resultSet={this.state.resultSet} targetedResultSet="studies_per_day" title="Studies Per Day"/>
                </div>
            </div>
        );
    }
}

export default App;