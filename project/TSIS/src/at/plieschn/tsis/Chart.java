package at.plieschn.tsis;


import java.util.Vector;

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

    private class Point {
    	public int index;
    	public long time;
    	public float distance;
    	public double altitude;
    }
    private Vector<Point> points;

    private void redrawChart() {
    	currentSeries.clear();
    	currentSeries.add(0, 0);
    	Point currentPoint = points.firstElement();
    	int pointIndex = 1;
		float y = 0;
    	for(int x = 1; x < 16; ++x) {
    		if (currentPoint.index == x) {
    			y = currentPoint.distance;
    			if(points.size() > pointIndex)
    				currentPoint = points.get(pointIndex++);
    		}
    		currentSeries.add(x, y);
    	}
    	if(chartView != null)
    		chartView.repaint();
    }
    
    public Chart(String title) {    	
        renderer.setApplyBackgroundColor(true);
        renderer.setMarginsColor(Color.argb(0x00, 0x01, 0x01, 0x01));
        renderer.setBackgroundColor(Color.TRANSPARENT);
        
        currentSeries = new XYSeries(title);
        dataset.addSeries(currentSeries);
        currentRenderer = new XYSeriesRenderer();
        renderer.addSeriesRenderer(currentRenderer);
        
        points = new Vector<Point>();
    }
    
    public GraphicalView init(Context context) {
    	if(chartView == null) {
    		chartView = ChartFactory.getLineChartView(context, dataset, renderer);
    	}
        return chartView;
    }
    
    public void addData(long time, float distance, double altitude) {
    	if(points.isEmpty()) {
    		Point newPoint = new Point();
    		newPoint.index = 1;
    		newPoint.time = time;
    		newPoint.distance = distance;
    		newPoint.altitude = altitude;
    		points.add(newPoint);
    	}
    	else {
    		long quartHour = 15*60*1000;
    		Point firstPoint = points.firstElement();
    		Point lastPoint = points.lastElement();
    		long startTime = firstPoint.time;
    		while(firstPoint != lastPoint && (startTime + quartHour) < time) {
    			points.remove(0);
    			firstPoint = points.firstElement();
    			startTime = firstPoint.time;
    		}
    		
    		if((lastPoint.time + quartHour) < time) {
    			points.clear();
        		Point newPoint = new Point();
        		newPoint.index = 1;
        		newPoint.time = time;
        		newPoint.distance = distance;
        		newPoint.altitude = altitude;
        		points.add(newPoint);   			
    		} else {
    			int index = (int)((time - startTime)/60000) + 1;
    			if(lastPoint.index == index) {
    				lastPoint.time = time;
    				lastPoint.distance = distance;
    				lastPoint.altitude = altitude;
    			} else {
        			points.clear();
            		Point newPoint = new Point();
            		newPoint.index = index;
            		newPoint.time = time;
            		newPoint.distance = distance;
            		newPoint.altitude = altitude;
            		points.add(newPoint);    				
    			}
    		}
    	}
    	redrawChart();
    }
}
