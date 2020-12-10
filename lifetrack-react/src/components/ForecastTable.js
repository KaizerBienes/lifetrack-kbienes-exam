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
                <td>{Math.ceil(resultSetItem.total_studies).toLocaleString()}</td>
                <td>{this.formatCurrency(resultSetItem.cost_forecasted_in_usd.ram_cost)}</td>
                <td>{this.formatCurrency(resultSetItem.cost_forecasted_in_usd.storage_cost)}</td>
                <td>{this.formatCurrency(resultSetItem.cost_forecasted_in_usd.total_cost)}</td>
            </tr>
        );
        return (
            <table className="ForecastTable">
                <thead>
                    <tr>
                        <th>Month Year</th>
                        <th className="studyHeader">Studies per Day</th>
                        <th className="studyHeader">Total Studies</th>
                        <th className="costHeader">Ram Cost</th>
                        <th className="costHeader">Storage Cost</th>
                        <th className="costHeader">Total Cost Forecasted</th>
                    </tr>
                </thead>
                <tbody>
                    {listItems}
                </tbody>
            </table>
        );
    }
}

export default ForecastTable;