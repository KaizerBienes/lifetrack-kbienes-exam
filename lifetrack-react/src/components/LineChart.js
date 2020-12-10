import './_LineChart.scss';
import React, {Component} from 'react';
import { Line } from 'react-chartjs-2';

class LineChart extends Component {
    constructor(props) {
        super(props);
        this.generateChart = this.generateChart.bind(this);
    }

    generateChart() {
        const COST = 'cost';
        const STUDIES_PER_DAY = 'studies_per_day';

        let resultSet = this.props.resultSet;
        let targetedResultSet = this.props.targetedResultSet || COST;
        if (resultSet.length === 0) {
            return;
        }

        let resultSetLabels = resultSet.map(function(resultItem) {
            return resultItem.month_year || undefined;
        })

        let resultSetData = resultSet.map(function(resultSetItem) {
            if (targetedResultSet === COST)
                return resultSetItem.cost_forecasted_in_usd?.total_cost || 0;
            else if (targetedResultSet === STUDIES_PER_DAY)
                return resultSetItem.studies_per_day || 0;
            else
                return 0;
        })

        return {
            labels: resultSetLabels,
            datasets: [
                {
                    label: "Forecasted Data",
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: 'rgba(192,192,192,0)',
                    borderColor: (targetedResultSet === COST) ? 'rgba(150,150,255,1)' : 'rgba(100,100,100,1)',
                    pointBorderColor: (targetedResultSet === COST) ? 'rgba(0,0,150,1)' : 'rgba(0,0,0,1)',
                    pointBackgroundColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: 'rgba(75,192,192,0.5)',
                    pointHoverBorderColor: 'rgba(220,220,220,0.5)',
                    pointHoverBorderWidth: 2,
                    data: resultSetData
                }
            ]
        }

    }

  render() {
    return (
      <div className="LineChart">
        <h2>{this.props.title}</h2>
        <Line ref="chart" data={this.generateChart()} />
      </div>
    );
  }
}

export default LineChart;