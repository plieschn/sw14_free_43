package at.plieschn.tsis.test;

import com.robotium.solo.Solo;

import android.test.ActivityInstrumentationTestCase2;
import at.plieschn.tsis.MainActivity;

public class ChartTest extends ActivityInstrumentationTestCase2<MainActivity>{

	private ChartTestClass chart;
	private Solo solo;
	
	public ChartTest() {
		super(MainActivity.class);
	}
	
	public ChartTest(Class<MainActivity> activityClass) {
		super(activityClass);
	}
	
	protected void setUp() throws Exception {
		super.setUp();
		solo = new Solo(getInstrumentation(), getActivity());
		
		chart = new ChartTestClass(solo.getString(at.plieschn.tsis.R.string.distance_fifteen_min),
				solo.getString(at.plieschn.tsis.R.string.altitude_fifteen_min), 
				solo.getString(at.plieschn.tsis.R.string.height_fifteen_min));
		
		chart.init(getActivity());
	}
	
	public void testOverwritePoints() {
		chart.addData(100000000, 100, 50, 300);
		assertEquals("Is point stored?", 1, chart.numPoints());
		assertEquals("Is first point in dataset still the root?", 0.0, chart.getDistanceOf(0));
		assertEquals("Is it in dataset", 100.0, chart.getDistanceOf(1));
		
		chart.addData(100030000, 150, 51, 301);
		assertEquals("Is there still only one point?", 1, chart.numPoints());
		assertEquals("Is first point overwritten?", 150.0, chart.getPointDistanceOf(0));
		assertEquals("but still with same time?", 100000000, chart.getPointTimeOf(0));
		assertEquals("Is it in dataset", 150.0, chart.getDistanceOf(1));
		
		chart.addData(100059999, 180, 52, 302);
		assertEquals("Is there still only one point?", 1, chart.numPoints());
		assertEquals("Is first point overwritten again?", 180.0, chart.getPointDistanceOf(0));
		assertEquals("but still with same time?", 100000000, chart.getPointTimeOf(0));
		assertEquals("Is it in dataset", 180.0, chart.getDistanceOf(1));
		
		chart.addData(100060000, 190, 53, 303);
		assertEquals("Is there now a new point?", 2, chart.numPoints());
		assertEquals("Is it in dataset", 180.0, chart.getDistanceOf(1));
		assertEquals("Is it in dataset", 190.0, chart.getDistanceOf(2));
	}
	
	public void testDeleteOldPoints() {
		chart.addData(100000000, 100, 50, 300);
		
		assertEquals("Is point stored?", 1, chart.numPoints());
		
		chart.addData(100060000, 200, 65, 350);
		assertEquals("Are two points stored?", 2, chart.numPoints());

		chart.addData(100120000, 220, 65, 350);
		assertEquals("Are three points stored?", 3, chart.numPoints());

		chart.addData(100180000, 300, 65, 350);
		assertEquals("Are four points stored?", 4, chart.numPoints());

		chart.addData(100240000, 310, 65, 350);
		assertEquals("Are five points stored?", 5, chart.numPoints());

		chart.addData(100300000, 350, 65, 350);
		assertEquals("Are six points stored?", 6, chart.numPoints());

		chart.addData(100360000, 400, 65, 350);
		assertEquals("Are seven points stored?", 7, chart.numPoints());

		chart.addData(100420000, 450, 65, 350);
		assertEquals("Are eight points stored?", 8, chart.numPoints());
		
		chart.addData(100480000, 510, 65, 350);
		assertEquals("Are nine points stored?", 9, chart.numPoints());
		
		chart.addData(100540000, 600, 65, 350);
		assertEquals("Are ten points stored?", 10, chart.numPoints());
		
		chart.addData(100600000, 680, 65, 350);
		assertEquals("Are eleven points stored?", 11, chart.numPoints());
		
		chart.addData(100660000, 690, 65, 350);
		assertEquals("Are twelve points stored?", 12, chart.numPoints());

		chart.addData(100720000, 700, 65, 350);
		assertEquals("Are thirteen points stored?", 13, chart.numPoints());

		chart.addData(100780000, 800, 65, 350);
		assertEquals("Are fourteen points stored?", 14, chart.numPoints());

		chart.addData(100840000, 820, 65, 350);
		assertEquals("Are fiveteen points stored?", 15, chart.numPoints());
		
		chart.addData(100900000, 900, 65, 350);
		assertEquals("Are still fiveteen points stored?", 15, chart.numPoints());
		assertEquals("Is first point the second ever stored point?", 200.0, chart.getPointDistanceOf(0));
		assertEquals("With correct time?", 100060000, chart.getPointTimeOf(0));
		
		chart.addData(101200000, 920, 65, 350);
		assertEquals("Are the first five points deleted?", 11, chart.numPoints());
		assertEquals("Is first point the seventh ever stored point?", 400.0, chart.getPointDistanceOf(0));
		assertEquals("With correct time?", 100360000, chart.getPointTimeOf(0));
		
		chart.addData(102100000, 930, 65, 350);
		assertEquals("Are all other points deleted?", 1, chart.numPoints());
		assertEquals("Is first point the last ever stored point?", 930.0, chart.getPointDistanceOf(0));
		assertEquals("With correct time?", 102100000, chart.getPointTimeOf(0));
	}

}
