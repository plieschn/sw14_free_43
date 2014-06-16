package at.plieschn.tsis;

import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;
import java.util.Vector;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.BasicHttpContext;
import org.apache.http.protocol.HttpContext;
import org.apache.http.util.EntityUtils;

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
	
	protected boolean uploadTrack(String host, String username, String password, KmlTrack track) {
		HttpClient httpClient = new DefaultHttpClient();
		HttpContext httpContext = new BasicHttpContext();
		HttpPost httpPost = new HttpPost(host);
		try {			
	        List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
	        nameValuePairs.add(new BasicNameValuePair("project_name", track.getTrackName()));
	        nameValuePairs.add(new BasicNameValuePair("username", username));
	        nameValuePairs.add(new BasicNameValuePair("password", password));
	        nameValuePairs.add(new BasicNameValuePair("file_content", track.createKml()));
			
	        httpPost.setEntity(new UrlEncodedFormEntity(nameValuePairs));			

			HttpResponse response = httpClient.execute(httpPost, httpContext);
			String result = EntityUtils.toString(response.getEntity());
			if(result.equals("true"))
				return true;
			
		} catch (UnsupportedEncodingException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (ClientProtocolException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
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
			if(uploadTrack(host, username, password, track))
				caller.trackTransfered(track);
		}
		
		Vector<Location> storedLocation = caller.getLocations();
		KmlTrack newTrack = new KmlTrack(storedLocation, trackName, trackNum);
		if(!uploadTrack(host, username, password, newTrack))
			caller.saveKmlTrack(newTrack);
		
		return null;
	}
}
