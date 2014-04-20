package at.plieschn.tsis;

import java.util.Vector;

import android.content.Context;
import android.location.Location;
import android.location.LocationManager;
import android.widget.TextView;

public class TsisLocationHandler {
    private static final long MINIMUM_DISTANCE_CHANGE_FOR_UPDATES = 1; // in Meters
    private static final long MINIMUM_TIME_BETWEEN_UPDATES = 1000; // in Milliseconds

	private Vector<Location> storedLocation;
	private TsisLocationListener listener;
	private LocationManager locationManager;
	
	private float distance = 0;
	private double altitude = 0.0;
	private TextView distanceTextView;
	private TextView altitudeTextView;
	
	public TsisLocationHandler(MainActivity activity) {
		locationManager = (LocationManager) activity.getSystemService(Context.LOCATION_SERVICE);
		listener = new TsisLocationListener(this);
		distanceTextView = (TextView) activity.findViewById(R.id.distanceTextView);
		altitudeTextView = (TextView) activity.findViewById(R.id.altitudeTextView);
		storedLocation = new Vector<Location>();
	}
	
	public void updateLocation(Location location) {
    	System.out.println("DEBUG: got location");
		
		if(!storedLocation.isEmpty())
		{
			distance += location.distanceTo(storedLocation.lastElement());
			
			altitude += Math.abs(storedLocation.lastElement().getAltitude() - location.getAltitude());
		}
		
		storedLocation.add(location);
		
    	System.out.println("DEBUG: latitude " + location.getLatitude());
    	System.out.println("DEBUG: longitude " + location.getLongitude());
    	System.out.println("DEBUG: height " + location.getAltitude());
		
		distanceTextView.setText(distance + "m");
		altitudeTextView.setText(altitude + "m");
	}

	public void startLocationTracking() {
		
		locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER,
											   MINIMUM_TIME_BETWEEN_UPDATES,
											   MINIMUM_DISTANCE_CHANGE_FOR_UPDATES, 
											   listener);
		/*locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,
											   MINIMUM_TIME_BETWEEN_UPDATES,
											   MINIMUM_DISTANCE_CHANGE_FOR_UPDATES, 
											   listener);*/
	}
	
	public void stopLocationTracking() {
		locationManager.removeUpdates(listener);
		distanceTextView.setText("");
	}
}
