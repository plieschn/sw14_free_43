package at.plieschn.tsis.test;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.lang.reflect.Method;
import java.util.Vector;

import android.location.Location;
import android.location.LocationManager;
import android.test.ActivityInstrumentationTestCase2;
import android.util.Log;
import at.plieschn.tsis.KmlTrack;
import at.plieschn.tsis.MainActivity;

public class KmlTests extends ActivityInstrumentationTestCase2<MainActivity> {
	
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
	
	public KmlTests() {
		super(MainActivity.class);
	}
	
	public KmlTests(Class<MainActivity> activityClass) {
		super(activityClass);
	}
	
	public void testCreateKml() {
		Location locationA = createLocation(47.069523, 15.450572, 354.110, 1000000);
		Location locationB = createLocation(47.069612, 15.450412, 354.210, 1060000);
		Location locationC = createLocation(47.069643, 15.450456, 354.520, 1120000);
		
		Vector<Location> locationVector = new Vector<Location>();
		locationVector.add(locationA);
		locationVector.add(locationB);
		locationVector.add(locationC);
		
		KmlTrack track = new KmlTrack(locationVector, "TSIS Tracker", 1);
		String kml = track.createKml();
		
		assertTrue("Is track name set correctly?", "TSIS Tracker".equals(track.getTrackName()));
		
		InputStream inputStream = getActivity().getResources().openRawResource(at.plieschn.tsis.R.raw.testlocation);
        ByteArrayOutputStream outputStream = new ByteArrayOutputStream();

        byte buf[] = new byte[1024];
        int len;
        try {
            while ((len = inputStream.read(buf)) != -1) {
                outputStream.write(buf, 0, len);
            }
            
            String testKml = outputStream.toString();
            
            int length = testKml.length() < kml.length() ? testKml.length() : kml.length(); 
            Log.d("kml", "string lengths: "+ testKml.length() + " " + kml.length());
            for(int i = 0; i < length; ++i)
            {
            	if(testKml.charAt(i) != kml.charAt(i)) {
            		Log.d("kml", "wrong char at "+i+" expacted "+kml.charAt(i)+ " but was " + testKml.charAt(i));
            		break;
            	}
            }
            
            outputStream.close();
            inputStream.close();
            
            assertTrue("Is created KML equal?", testKml.equals(kml));
        } catch (IOException e) {
        	assertTrue("IOException got thrown", false); //outputStream.toString().equals(track.createKml()));
        }
	}
}
