package at.plieschn.tsis;

import java.util.Vector;

import android.location.Location;
import android.os.AsyncTask;

public class UploadTrackTask extends AsyncTask<String, Void, Void> {
	public interface OnTrackUploaded {
		public void onTrackUploaded();
		public Vector<Location> getLocations();
		public void saveKmlTrack(KmlTrack track);
		public Vector<KmlTrack> getTracks();
		public void trackTransfered(KmlTrack track);
	}
	
	private OnTrackUploaded caller;
	
	private boolean uploadTrack(String host, String username, String password, KmlTrack track) {
		return false;
	}
	
	public UploadTrackTask(OnTrackUploaded caller) {
		this.caller = caller;
	}
	
	@Override
	protected void onPostExecute(Void result) {
		super.onPostExecute(result);
		
		if(caller != null) {
			caller.onTrackUploaded();
		}
	}

	@Override
	protected Void doInBackground(String... params) {
		String host = params[0];
		String username = params[1];
		String password = params[2];
		String trackName = params[3];
		int trackNum = Integer.parseInt(params[4]);
		
		for(KmlTrack track: caller.getTracks()) {
			uploadTrack(host, username, password, track);
		}
		
		Vector<Location> storedLocation = caller.getLocations();
		KmlTrack newTrack = new KmlTrack(storedLocation, trackName, trackNum);
		if(!uploadTrack(host, username, password, newTrack))
			caller.saveKmlTrack(newTrack);
		
		return null;
	}
}
