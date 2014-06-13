package at.plieschn.tsis;

import android.os.AsyncTask;

public class UploadTrackTask extends AsyncTask<String, Void, Void> {
	public interface OnTrackUploaded {
		public void onTrackUploaded();
	}
	
	private OnTrackUploaded caller;
	
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
		return null;
	}
}
