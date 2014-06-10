package at.plieschn.tsis;

import android.support.v7.app.ActionBarActivity;
import android.support.v4.app.Fragment;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.ServiceConnection;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.IBinder;
import android.preference.PreferenceManager;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.TextView;
import android.widget.ToggleButton;
import at.plieschn.tsis.TsisLocationHandler.OnLocationChanged;
import at.plieschn.tsis.TsisLocationHandler.TsisLocationBinder;

public class MainActivity extends ActionBarActivity implements OnLocationChanged {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        if (savedInstanceState == null) {
            getSupportFragmentManager().beginTransaction()
                    .add(R.id.container, new PlaceholderFragment())
                    .commit();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        if (id == R.id.action_settings) {
        	Intent intent = new Intent(this, PreferencesActivity.class);
        	startActivity(intent);
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    public static class PlaceholderFragment extends Fragment implements OnClickListener {
    	private ToggleButton startStopButton;
    	
    	@Override
		public void onActivityCreated(Bundle savedInstanceState) {
			super.onActivityCreated(savedInstanceState);
    		startStopButton = (ToggleButton)getActivity().findViewById(R.id.startStopButton);
    		startStopButton.setOnClickListener(this);
		}

		@Override
        public View onCreateView(LayoutInflater inflater, ViewGroup container,
                Bundle savedInstanceState) {
            View rootView = inflater.inflate(R.layout.fragment_main, container, false);
            return rootView;
        }

		@Override
		public void onClick(View v) {
			if(v.getId() == startStopButton.getId()) {
				MainActivity activity = (MainActivity)getActivity();
				if(startStopButton.isChecked()) {
					activity.getSupportActionBar().setIcon(R.drawable.ic_launcher_running);
					activity.startLocationService();

				} else {
					activity.getSupportActionBar().setIcon(R.drawable.ic_launcher);
					getActivity().stopService(new Intent(getActivity(), TsisLocationHandler.class));
				}
			}
		}
    }
    
    public void startLocationService() {
		SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(this);
		int max_accuracy = Integer.parseInt(preferences.getString("max_accuracy", "100"));
		int minimum_time_difference = Integer.parseInt(preferences.getString("minimum_time_difference", "0"));
		int minimum_distance_difference = Integer.parseInt(preferences.getString("minimum_distance_difference", "0"));
		
    	Intent intent = new Intent(this, TsisLocationHandler.class);
    	intent.putExtra("max_accuracy", max_accuracy);
    	intent.putExtra("minimum_time_difference", minimum_time_difference);
    	intent.putExtra("minimum_distance_difference", minimum_distance_difference);
    	System.out.println("DEBUG: pressed button");
		startService(intent);
		ServiceConnection connection = new ServiceConnection() {

			@Override
			public void onServiceConnected(ComponentName name,
					IBinder service) {
				TsisLocationBinder binder = (TsisLocationBinder) service;
				TsisLocationHandler locationService = binder.getService();
				MainActivity activity = MainActivity.this;
				locationService.setCaller(activity);
				locationService.initChart(activity);
				FrameLayout layout = (FrameLayout) activity.findViewById(R.id.chart);
				layout.addView(locationService.initChart(activity));
			}

			@Override
			public void onServiceDisconnected(ComponentName name) {
				
			}
			
		};
		bindService(intent, connection, Context.BIND_AUTO_CREATE);
		
    }

	@Override
	public void locationChanged() {
		float distance = TsisLocationHandler.getDistance();
		System.out.println("DEBUG: distance " + distance);
		
		TextView distanceTextView = (TextView) findViewById(R.id.distanceTextView);
		distanceTextView.setText(distance + "m");
	}
}
