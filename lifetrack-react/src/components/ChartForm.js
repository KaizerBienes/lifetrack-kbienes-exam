import React, { Component } from 'react';
import './_ChartForm.scss';
import { Input, InputLabel, FormControl, FormHelperText, TextField } from '@material-ui/core';

class ChartForm extends Component {
    constructor(props) {
        super(props);
        this.changeFormState = this.changeFormState.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    changeFormState(event) {
        this.props.onChangeFormValue(event.target.name, event.target.value);
    }

    handleSubmit(event) {
        event.preventDefault();
    }

    render() {
        return (
            <div className="ChartForm">
                <FormControl onSubmit={this.handleSubmit}>
                    <TextField
                        id="number-of-study-per-day"
                        name="numberOfStudyPerDay"
                        label="Number of Study Per Day"
                        type="number"
                        value={this.props.numberOfStudyPerDay}
                        onChange={this.changeFormState}
                        aria-describedby="my-helper-text"
                        InputLabelProps={{
                            shrink: true,
                        }}
                        variant="outlined"
                    />
                    <TextField
                        id="number-of-study-growth-per-month"
                        name="numberOfStudyGrowthPerMonth"
                        label="Study growth per month (%):"
                        type="number"
                        value={this.props.numberOfStudyGrowthPerMonth}
                        onChange={this.changeFormState}
                        InputLabelProps={{
                            shrink: true,
                        }}
                        variant="outlined"
                    />
                    <TextField
                        id="months-to-forecast"
                        name="monthsToForecast"
                        label="Months to Forecast"
                        type="number"
                        value={this.props.monthsToForecast}
                        onChange={this.changeFormState}
                        InputLabelProps={{
                            shrink: true,
                        }}
                        variant="outlined"
                    />
                </FormControl>
                { this.props.inputErrors !== null && this.props.inputErrors !== '' &&
                    <div className="inputErrors">
                        <h5>Input Errors</h5>
                        {this.props.inputErrors}
                    </div>
                }
            </div>
        );

    }
}

export default ChartForm;
