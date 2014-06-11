package at.plieschn.tsis;

import java.util.Vector;

import org.achartengine.GraphicalView;

import android.app.Notification;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.os.Binder;
import android.os.IBinder;
import android.support.v4.app.NotificationCompat;
import android.support.v4.app.TaskStackBuilder;
import android.util.Log;

public class TsisLocationHandler extends Service {
	public interface OnLocationChanged {
		public void locationChanged();
	}

	public class TsisLocationBinder extends Binder {
		TsisLocationHandler getService() {
			return TsisLocationHandler.this;
		}
	}
	
    int maxAccuracy;
    int minimumTimeDifference;
    int minimumDistanceDifference;

	private final int SERVICE_RUNNING_NOTIFICATION_ID = 0x01;
    private final IBinder tsisLocationBinder = new TsisLocationBinder();
    
	private Vector<Location> storedLocation;
	private TsisLocationListener listener;
	private LocationManager locationManager;
	
	private Chart chart;
	
	private static float distance = 0;
	private double altitude = 0.0;
	private OnLocationChanged caller;
	
	/*public TsisLocationHandler(MainActivity activity) {
//		locationManager = (LocationManager) activity.getSystemService(Context.LOCATION_SERVICE);
		listener = new TsisLocationListener(this);
		distanceTextView = (TextView) activity.findViewById(R.id.distanceTextView);
		altitudeTextView = (TextView) activity.findViewById(R.id.altitudeTextView);
		storedLocation = new Vector<Location>();
	}*/
	
	public void updateLocation(Location location) {
    	System.out.println("DEBUG: got location");
    	double height = 0.0;
		
		if(!storedLocation.isEmpty())
		{
			distance += location.distanceTo(storedLocation.lastElement());
			height = location.getAltitude();
			if(height == 0.0)
				height = Math.random() * 50;
			altitude += Math.abs(storedLocation.lastElement().getAltitude() - height);
		}
		
		storedLocation.add(location);
		
    	if(caller != null)
    		caller.locationChanged();
		//distanceTextView.setText(distance + "m");
		//altitudeTextView.setText(altitude + "m");
    	
    	chart.addData(location.getTime(), distance, altitude, height);
	}

	public void startLocationTracking() {
		locationManager = (LocationManager) this.getSystemService(Context.LOCATION_SERVICE);
		listener = new TsisLocationListener(this);
		locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER,
				minimumTimeDifference,
				minimumDistanceDifference, 
				listener);
		locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,
				minimumTimeDifference,
				minimumDistanceDifference, 
				listener);
	}
	
	public void stopLocationTracking() {
		locationManager.removeUpdates(listener);
		//distanceTextView.setText("");
	}
	
	public void setCaller(OnLocationChanged newCaller) {
		System.out.println("DEBUG: caller set");
		caller = newCaller;
	}
	
	public GraphicalView initChart(Context context) {
		return chart.init(context);
	}
	
	public static float getDistance() {
		return distance;
	}
	
	@Override
	public void onCreate() {
		super.onCreate();
		Log.d("Service", "onCreate");
		storedLocation = new Vector<Location>();
		chart = new Chart();
	}

	@Override
	public IBinder onBind(Intent intent) {
		return tsisLocationBinder;
	}
	
	@Override 
	public int onStartCommand(Intent intent, int flags, int startId) {
		super.onStartCommand(intent, flags, startId);
		maxAccuracy = intent.getExtras().getInt("max_accuracy");
		minimumTimeDifference = intent.getExtras().getInt("minimum_time_difference");
		minimumDistanceDifference = intent.getExtras().getInt("minimum_distance_difference");
    	System.out.println("DEBUG: start Location Tracking");
		startLocationTracking();
		
		NotificationCompat.Builder builder = new NotificationCompat.Builder(this)
		.setSmallIcon(R.drawable.ic_launcher)
		.setContentTitle(getString(R.string.service_running_title))
		.setContentText(getString(R.string.service_running_text));
	
		Intent result_intent = new Intent(this, MainActivity.class);
		TaskStackBuilder stack_builder = TaskStackBuilder.create(this);
		stack_builder.addNextIntent(result_intent);
		PendingIntent result_pending_intent =
				stack_builder.getPendingIntent(0, PendingIntent.FLAG_UPDATE_CURRENT);
	
		builder.setContentIntent(result_pending_intent);
		Notification notification = builder.build();

		startForeground(SERVICE_RUNNING_NOTIFICATION_ID, notification);
		
		return START_STICKY;
	}

	public void onDestroy() {
		stopLocationTracking();
		stopForeground(true);
	}
	
	public void requestStop() {
		stopLocationTracking();
		stopForeground(true);
		stopSelf();
	}
}
