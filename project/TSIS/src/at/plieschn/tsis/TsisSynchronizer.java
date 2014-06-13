package at.plieschn.tsis;

import java.util.concurrent.Delayed;
import java.util.concurrent.ExecutionException;
import java.util.concurrent.RunnableScheduledFuture;
import java.util.concurrent.TimeUnit;
import java.util.concurrent.TimeoutException;

import at.plieschn.tsis.UploadTrackTask.OnTrackUploaded;

public class TsisSynchronizer implements OnTrackUploaded, RunnableScheduledFuture<Void>{
	private TsisLocationHandler handler;
	private boolean done;
	private String host;
	private String username;
	private String password;

	public TsisSynchronizer(TsisLocationHandler handler,
			String host, String username, String password) {
		super();
		this.handler = handler;
		this.host = host;
		this.username = username;
		this.password = password;
	}
	
	@Override
	public void run() {
		if(handler.getStoredLocation() == null) {
			return;
		}

		done = false;
		UploadTrackTask uploadTrackTask = new UploadTrackTask(this);
		uploadTrackTask.execute(host, username, password);
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


}
