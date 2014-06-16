package at.plieschn.tsis.test;

import android.util.Log;
import at.plieschn.tsis.KmlTrack;
import at.plieschn.tsis.UploadTrackTask;

public class UploadTrackTest extends UploadTrackTask{

	public UploadTrackTest() {
		super(null);
	}

	public boolean testUploadTrack(String host, String username, String password, KmlTrack track) {
		Log.d("HttpResponse", "testUploadTrack(...)");
		return uploadTrack(host, username, password, track);
	}
}
