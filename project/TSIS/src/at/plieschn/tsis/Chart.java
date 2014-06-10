package at.plieschn.tsis;

import org.achartengine.ChartFactory;
import org.achartengine.GraphicalView;
import org.achartengine.chart.BarChart.Type;
import org.achartengine.model.XYMultipleSeriesDataset;
import org.achartengine.model.XYSeries;
import org.achartengine.renderer.XYMultipleSeriesRenderer;
import org.achartengine.renderer.XYSeriesRenderer;

import android.content.Context;
import android.graphics.Color;

public class Chart {
    private GraphicalView chartView;

    private XYMultipleSeriesDataset dataset = new XYMultipleSeriesDataset();
    private XYMultipleSeriesRenderer renderer = new XYMultipleSeriesRenderer();
    private XYSeries currentSeries;
    private XYSeriesRenderer currentRenderer;

    private void addSampleData() {
        currentSeries.add(1, 2);
        currentSeries.add(2, 3);
        currentSeries.add(3, 2);
        currentSeries.add(4, 5);
        currentSeries.add(5, 4);
    }
    
    public Chart(String title) {    	
        renderer.setApplyBackgroundColor(true);
        renderer.setMarginsColor(Color.argb(0x00, 0x01, 0x01, 0x01));
        renderer.setBackgroundColor(Color.TRANSPARENT);
        
        currentSeries = new XYSeries(title);
        dataset.addSeries(currentSeries);
        currentRenderer = new XYSeriesRenderer();
        renderer.addSeriesRenderer(currentRenderer);
    }
    
    public GraphicalView init(Context context) {
    	if(chartView == null)
    	{
    		chartView = ChartFactory.getBarChartView(context, dataset, renderer, Type.DEFAULT);
    	}
        return chartView;
    }
    
    public void drawChart() {
        addSampleData();
        chartView.repaint();
    }
}
