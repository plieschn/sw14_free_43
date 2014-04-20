package at.plieschn.tsis;

import android.location.Location;
import android.location.LocationListener;
import android.os.Bundle;

public class TsisLocationListener implements LocationListener{

	TsisLocationHandler locationHandler;
	
	public TsisLocationListener(TsisLocationHandler handler) {
		locationHandler = handler;
	}
	
	@Override
	public void onLocationChanged(Location location) {
		locationHandler.updateLocation(location);
	}

	@Override
	public void onStatusChanged(String provider, int status, Bundle extras) {
	}

	@Override
	public void onProviderEnabled(String provider) {
	}

	@Override
	public void onProviderDisabled(String provider) {		
	}

}
