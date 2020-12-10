import './_ForecastTable.scss';
import React, { Component } from 'react';

class ForecastTable extends Component {
    constructor(props) {
        super(props);
        this.formatCurrency = this.formatCurrency.bind(this);
    }

    formatCurrency(number) {
        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD'}).format(number)
    }

    render() {
        const resultSet = this.props.resultSet;
        const listItems = resultSet.map((resultSetItem) =>
            <tr>
                <td>{resultSetItem.month_year}</td>
                <td>{Math.ceil(resultSetItem.studies_per_day).toLocaleString()}</td>
                <td>{this.formatCurrency(resultSetItem.cost_forecasted_in_usd.total_cost)}</td>
            </tr>
        );
        return (
            <div className="ForecastTable mdc-data-table">
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Month Year</th>
                                <th>Number of Studies</th>
                                <th>Cost Forecasted</th>
                            </tr>
                        </thead>
                        <tbody>
                            {listItems}
                        </tbody>
                    </table>
                </div>
            </div>
        );
    }
}

export default ForecastTable;