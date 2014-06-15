package at.plieschn.tsis.test;

import at.plieschn.tsis.Chart;

public class ChartTestClass extends Chart{
	public ChartTestClass(String distanceTitle, String altitudeTitle, String heightTitle) {
		super(distanceTitle, altitudeTitle, heightTitle);
	}
	
	public int numPoints() {
		return points.size();
	}
	
	public long getPointTimeOf(int index) {
		return points.get(index).time;
	}
	
	public double getPointDistanceOf(int index) {
		return points.get(index).distance;
	}
	
	public double getDistanceOf(int index) {
		return distanceSeries.getY(index);
	}
	
	
}
