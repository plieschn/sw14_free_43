package at.plieschn.tsis;


import java.text.DecimalFormat;
import java.util.Vector;

import org.achartengine.ChartFactory;
import org.achartengine.GraphicalView;
import org.achartengine.chart.BarChart;
import org.achartengine.chart.LineChart;
import org.achartengine.model.XYMultipleSeriesDataset;
import org.achartengine.model.XYSeries;
import org.achartengine.renderer.XYMultipleSeriesRenderer;
import org.achartengine.renderer.XYSeriesRenderer;

import android.content.Context;
import android.graphics.Color;

public class Chart {
    private GraphicalView chartView;

    private XYMultipleSeriesDataset dataset = new XYMultipleSeriesDataset();
    private XYMultipleSeriesRenderer renderer = new XYMultipleSeriesRenderer(2);
    private XYSeries distanceSeries;
    private XYSeries altitudeSeries;
    private XYSeries heightSeries;
    private XYSeriesRenderer distanceRenderer;
    private XYSeriesRenderer altitudeRenderer;
    private XYSeriesRenderer heightRenderer;
    
    private String[] types;

    private class Point {
    	public int index;
    	public long time;
    	public float distance;
    	public double altitude;
    	public double height;
    }
    private Vector<Point> points;

    private void redrawChart() {
    	distanceSeries.clear();
    	distanceSeries.add(0, 0);
    	altitudeSeries.clear();
    	altitudeSeries.add(0, 0);
    	heightSeries.clear();
    	Point currentPoint = points.firstElement();
    	int pointIndex = 0;
		float distance = 0;
		double altitude = 0;
		double height = 0;

    	for(int x = 1; x < 16; ++x) {
        	if (points.size() <= pointIndex) {
        		break;
        	}
        	currentPoint = points.get(pointIndex);
        	if (currentPoint.index == x) {
    			distance = currentPoint.distance;
    			altitude = currentPoint.altitude;
    			height = currentPoint.height;
    			++pointIndex;
    		}
        	
    		distanceSeries.add(x, distance);
    		altitudeSeries.add(x, altitude);
    		heightSeries.add(x, height);
    	}
    	
    	renderer.setYAxisMin(0,1);
    	renderer.setYAxisMax(heightSeries.getMaxY(), 1);
    	if(chartView != null)
    		chartView.repaint();
    }
    
    public Chart(String distanceTitle, String altitudeTitle, String heightTitle) {
        renderer.setApplyBackgroundColor(true);
        renderer.setMarginsColor(Color.argb(0x00, 0x01, 0x01, 0x01));
        renderer.setBackgroundColor(Color.TRANSPARENT);
        
        distanceSeries = new XYSeries(distanceTitle, 0);
        altitudeSeries = new XYSeries(altitudeTitle, 0);
        heightSeries = new XYSeries(heightTitle, 1);
        dataset.addSeries(heightSeries);        
        dataset.addSeries(distanceSeries);
        dataset.addSeries(altitudeSeries);
        distanceRenderer = new XYSeriesRenderer();
        distanceRenderer.setChartValuesFormat(new DecimalFormat("#.##"));
        distanceRenderer.setDisplayChartValues(true);
        
        altitudeRenderer = new XYSeriesRenderer();
        altitudeRenderer.setColor(Color.GREEN);
        altitudeRenderer.setChartValuesFormat(new DecimalFormat("#.##"));
        altitudeRenderer.setDisplayChartValues(true);
        heightRenderer = new XYSeriesRenderer();
        heightRenderer.setColor(Color.CYAN);
        heightRenderer.setChartValuesFormat(new DecimalFormat("#.##"));
        heightRenderer.setDisplayChartValues(true);
        
        renderer.addSeriesRenderer(heightRenderer);
        renderer.addSeriesRenderer(distanceRenderer);
        renderer.addSeriesRenderer(altitudeRenderer);
        renderer.setXAxisMin(0.0);
        renderer.setXAxisMax(15.0);
        renderer.setXAxisMin(0.0, 1);
        renderer.setXAxisMax(15.0, 1);
                
        types = new String[] {BarChart.TYPE, LineChart.TYPE, LineChart.TYPE};
        
        points = new Vector<Point>();
    }
    
    public GraphicalView init(Context context) {
    	if(chartView == null) {
    		chartView = ChartFactory.getCombinedXYChartView(context, dataset, renderer, types);
    	}
        return chartView;
    }
    
    public void addData(long time, float distance, double altitude, double height) {
    	if(points.isEmpty()) {
    		Point newPoint = new Point();
    		newPoint.index = 1;
    		newPoint.time = time;
    		newPoint.distance = distance;
    		newPoint.altitude = altitude;
    		newPoint.height = height;
    		points.add(newPoint);
    	}
    	else {
    		long quartHour = 15*60*1000;
    		Point firstPoint = points.firstElement();
    		Point lastPoint = points.lastElement();
    		long startTime = firstPoint.time;
    		while(firstPoint != lastPoint && (startTime + quartHour) < time) {
    			points.remove(firstPoint);
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
        		newPoint.height = height;
        		points.add(newPoint);   			
    		} else {
    			int index = (int)((time - startTime)/60000) + 1;
    			if(lastPoint.index == index) {
    				lastPoint.distance = distance;
    				lastPoint.altitude = altitude;
    				lastPoint.height = height;
    			} else {
            		Point newPoint = new Point();
            		newPoint.index = index;
            		newPoint.time = time;
            		newPoint.distance = distance;
            		newPoint.altitude = altitude;
            		newPoint.height = height;
            		points.add(newPoint);    				
    			}
    		}
    	}
    	for (int i = 0; i < points.size(); ++i) {
    		points.get(i).index = i+1;
    	}
    	redrawChart();
    }
}
