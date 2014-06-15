package at.plieschn.tsis;

import java.util.Vector;
import java.util.concurrent.Delayed;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.RunnableScheduledFuture;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;

import android.location.Location;
import at.plieschn.tsis.UploadTrackTask.OnTrackUploaded;

public class TsisSynchronizer implements OnTrackUploaded, RunnableScheduledFuture<Void>{
	private TsisLocationHandler handler;
	private boolean done;
	private String host;
	private String username;
	private String password;
	
	private String trackName;
	private int trackNum;
	
	private Vector<KmlTrack> tracks;

	public TsisSynchronizer(TsisLocationHandler handler,
			String host, String username, String password, String trackName) {
		super();
		this.handler = handler;
		this.host = host;
		this.username = username;
		this.password = password;
		this.trackName = trackName;
		
		trackNum = 0;
		tracks = new Vector<KmlTrack>();
	}
	
	@Override
	public void run() {
		if(handler.getStoredLocation() == null) {
			return;
		}

		done = false;
		UploadTrackTask uploadTrackTask = new UploadTrackTask(this);
		uploadTrackTask.execute(host, username, password, trackName, ""+trackNum);
		++trackNum;
	}
	
	@Override
	public void onTrackUploaded() {
		// TODO Auto-generated method stub
		
	}

	@Override
	public boolean cancel(boolean mayInterruptIfRunning) {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public boolean isCancelled() {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public boolean isDone() {
		// TODO Auto-generated method stub
		return done;
	}

	@Override
	public Void get() throws InterruptedException, ExecutionException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public Void get(long timeout, TimeUnit unit) throws InterruptedException,
			ExecutionException, TimeoutException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public long getDelay(TimeUnit unit) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public int compareTo(Delayed another) {
		// TODO Auto-generated method stub
		return 0;
	}

	@Override
	public boolean isPeriodic() {
		// TODO Auto-generated method stub
		return false;
	}

	@Override
	public Vector<Location> getLocations() {
		return handler.getStoredLocation();
	}

	@Override
	public void saveKmlTrack(KmlTrack track) {
		tracks.add(track);
		
	}

	@Override
	public Vector<KmlTrack> getTracks() {
		return tracks;
	}

	@Override
	public void trackTransfered(KmlTrack track) {
		tracks.remove(track);
		
	}


}
