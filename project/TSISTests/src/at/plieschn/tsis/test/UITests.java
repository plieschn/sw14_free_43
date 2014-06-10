package at.plieschn.tsis.test;

import java.lang.reflect.Method;

import at.plieschn.tsis.MainActivity;
import android.content.Context;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationManager;
import android.test.ActivityInstrumentationTestCase2;
import android.widget.Button;
import android.widget.TextView;

import com.robotium.solo.Solo;


public class UITests extends ActivityInstrumentationTestCase2<MainActivity> {
	private Button startStopButton;
	private TextView distanceTextView;
	private Solo solo;
	
	private LocationManager testLocationManager;
	private static final String PROVIDER_NAME = LocationManager.GPS_PROVIDER;

	private void addTestProvider(final String providerName) {
		testLocationManager.addTestProvider(providerName, true, false, true, false, false, false, false, Criteria.POWER_MEDIUM, Criteria.ACCURACY_FINE);
		
	}
	
	private Location createLocation(float latitude, float longitude, double height) {
		Location location = new Location(PROVIDER_NAME);
        location.setLatitude(latitude);
        location.setLongitude(longitude);
        location.setAltitude(height);
        location.setAccuracy(1.0f);
        location.setTime(java.lang.System.currentTimeMillis());
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
	
	private void sendLocation(Location location) {
		testLocationManager.setTestProviderLocation(PROVIDER_NAME, location);
	}
    
	@Override
	protected void setUp() throws Exception {
		super.setUp();
		solo = new Solo(getInstrumentation(), getActivity());
		startStopButton = (Button) solo.getView(at.plieschn.tsis.R.id.startStopButton);
		distanceTextView = (TextView) solo.getView(at.plieschn.tsis.R.id.distanceTextView);
		testLocationManager = (LocationManager) getActivity().getApplicationContext().getSystemService(Context.LOCATION_SERVICE);
		
		addTestProvider(PROVIDER_NAME);
		//addTestProvider(LocationManager.NETWORK_PROVIDER);
	}

	@Override
	protected void tearDown() throws Exception {
		try {
			solo.finalize();
		} catch (Throwable e) {
			e.printStackTrace();
		}
		super.tearDown();
	}
		
	public UITests() {
		super(MainActivity.class);
	}
	
	public UITests(Class<MainActivity> activityClass) {
		super(activityClass);
	}

	public void testStartButton() {
		solo.clickOnToggleButton(startStopButton.getText().toString());
		assertEquals("Is startStopButton activated", true, solo.isToggleButtonChecked(0));
		solo.clickOnToggleButton(startStopButton.getText().toString());
		assertEquals("Is startStopButton deactivated", false, solo.isToggleButtonChecked(0));
	}
	
	public void testLocationHandling() {
		solo.clickOnToggleButton(startStopButton.getText().toString());

		solo.sleep(1000);
		System.out.println("DEBUG: CLICKED");
		Location locationA = createLocation((float)47.058765,(float)15.459198, 355.112);
		System.out.println("DEBUG: Send first Location");
		sendLocation(locationA);
		
		solo.sleep(1100);
		
		assertEquals("Is first Location send", "0.0m", distanceTextView.getText().toString());

		Location locationB = createLocation((float)47.069523,(float)15.450572, 354.110);		
		sendLocation(locationB);
		solo.sleep(1000);
		
		System.out.println("DEBUG: expected distance " + locationB.distanceTo(locationA));
		assertEquals("Is second Location send", locationB.distanceTo(locationA)+"m", distanceTextView.getText().toString());
	}
}
