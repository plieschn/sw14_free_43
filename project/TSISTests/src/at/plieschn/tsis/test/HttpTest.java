package at.plieschn.tsis.test;

import java.lang.reflect.Method;
import java.util.Vector;

import android.location.Location;
import android.location.LocationManager;
import android.test.ActivityInstrumentationTestCase2;
import android.util.Log;
import at.plieschn.tsis.KmlTrack;
import at.plieschn.tsis.MainActivity;

public class HttpTest extends ActivityInstrumentationTestCase2<MainActivity> {
	private Location createLocation(double latitude, double longitude, double height, long time) {
		Location location = new Location(LocationManager.GPS_PROVIDER);
        location.setLatitude(latitude);
        location.setLongitude(longitude);
        location.setAltitude(height);
        location.setAccuracy(1.0f);
        location.setTime(time);
        //location.setElapsedRealtimeNanos(SystemClock.elapsedRealtimeNanos());
        try { 
            Method makeComplete = Location.class.getMethod("makeComplete");
            if (makeComplete != null) {
                makeComplete.invoke(location);
            } 
        } catch (Exception e) {
        } 
		
		return location;
	}
	
	public HttpTest() {
		super(MainActivity.class);
	}
	public HttpTest(Class<MainActivity> activityClass) {
		super(activityClass);
	}

	protected void setUp() throws Exception {
		super.setUp();
	}
	
	public void testSendKml() {
		Log.d("HttpResponse", "test");
		System.out.println("HttpResponse: test");
		UploadTrackTest uploadTrackTest = new UploadTrackTest();
		
		long time = 1401637218;
		time *= 1000;
		
		Location locationA = createLocation(47.069523, 15.450572, 354.110, time);
		time += 60000;
		Location locationB = createLocation(47.069612, 15.450412, 354.210, time);
		time += 60000;
		Location locationC = createLocation(47.069643, 15.450456, 354.520, time);
		time += 60000;
		Location locationD = createLocation(47.069701, 15.450440, 354.320, time);
		time += 60000;
		Location locationE = createLocation(47.069720, 15.450438, 354.290, time);
		
		Vector<Location> locationVector = new Vector<Location>();
		locationVector.add(locationA);
		locationVector.add(locationB);
		locationVector.add(locationC);
		locationVector.add(locationD);
		locationVector.add(locationE);
		
		KmlTrack track = new KmlTrack(locationVector, "TestTrack", 0);
		
		boolean result = uploadTrackTest.testUploadTrack("http://home.plieschn.at/TSIS/Projects/Enter/", "TSISTest", "test", track);
		
		assertTrue("Could KML be transfered? (Is Server running correct)", result);
	}

}
