package at.plieschn.tsis;

import android.support.v7.app.ActionBarActivity;
import android.support.v4.app.Fragment;
import android.app.AlertDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
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
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.TextView;
import android.widget.ToggleButton;
import at.plieschn.tsis.TsisLocationHandler.OnLocationChanged;
import at.plieschn.tsis.TsisLocationHandler.TsisLocationBinder;

public class MainActivity extends ActionBarActivity implements OnLocationChanged {
	private class TsisServiceConnection implements ServiceConnection {
		@Override
		public void onServiceConnected(ComponentName name,
				IBinder service) {
			binder = (TsisLocationBinder) service;
		}

		@Override
		public void onServiceDisconnected(ComponentName name) {
			binder = null;
		}
	}

	private class TsisServiceConnectionUI implements ServiceConnection {
		@Override
		public void onServiceConnected(ComponentName name,
				IBinder service) {
			binder = (TsisLocationBinder) service;
			TsisLocationHandler locationService = binder.getService();
			MainActivity activity = MainActivity.this;
			locationService.setCaller(activity);
			locationService.initChart(activity); // FIXXXME
			FrameLayout layout = (FrameLayout) activity.findViewById(R.id.chart);
			layout.removeAllViews();
			layout.addView(locationService.initChart(activity));
		}

		@Override
		public void onServiceDisconnected(ComponentName name) {
			binder = null;
		}
	}

	
	@Override
	protected void onPause() {
		super.onPause();
		if(binder != null) {
			unbindService(connection);
			TsisLocationHandler.setSystemBinder(binder);
		}
	}

	@Override
	protected void onResume() {
		super.onResume();

		binder = TsisLocationHandler.getSystemBinder();
		
		if(binder != null) {
			if(binder.getService() != null) {
				ToggleButton startStopButton = (ToggleButton) findViewById(R.id.startStopButton);
				startStopButton.setChecked(true);
				getSupportActionBar().setIcon(R.drawable.ic_launcher_running);
				startLocationService(false);
			}
		}
	}

	private TsisLocationBinder binder;
	private ServiceConnection connection;
	private String projectName;

	protected TsisLocationBinder getBinder() {
		return binder;
	}

	protected void setBinder(TsisLocationBinder binder) {
		this.binder = binder;
	}
	
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
					activity.startLocationService(true);
				} else {
					activity.getSupportActionBar().setIcon(R.drawable.ic_launcher);
					((MainActivity)getActivity()).getBinder().getService().requestStop();
					((MainActivity)getActivity()).setBinder(null);
					activity.stopLocationService();
				}
			}
		}
    }
    
    public void startLocationService(boolean startService) {
		SharedPreferences preferences = PreferenceManager.getDefaultSharedPreferences(this);
		int max_accuracy = Integer.parseInt(preferences.getString("max_accuracy", "30"));
		int minimum_time_difference = Integer.parseInt(preferences.getString("minimum_time_difference", "0"));
		int minimum_distance_difference = Integer.parseInt(preferences.getString("minimum_distance_difference", "25"));
		
		Intent intent = new Intent(this, TsisLocationHandler.class);
    	intent.putExtra("max_accuracy", max_accuracy);
    	intent.putExtra("minimum_time_difference", minimum_time_difference);
    	intent.putExtra("minimum_distance_difference", minimum_distance_difference);
    	System.out.println("DEBUG: pressed button");

    	if(startService) {
    		getProjectName(intent);
    		
    	} else {
    		connection = new TsisServiceConnection();
    		bindService(intent, connection, Context.BIND_AUTO_CREATE);
    	}

    }
    
	private void getProjectName(final Intent intent) {
		AlertDialog.Builder builder = new AlertDialog.Builder(this);

		builder.setTitle("Project title");
		builder.setMessage("Please enter a project title:");

		// Set an EditText view to get user input 
		final EditText input = new EditText(this);
		builder.setView(input);

		builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int whichButton) {
				projectName = input.getText().toString();
		    	System.out.println("DEBUG: pressed button");
		    	intent.putExtra("project_name", projectName);
				startService(intent);
		    	connection = new TsisServiceConnectionUI();
	    		bindService(intent, connection, Context.BIND_AUTO_CREATE);
			}
		});

		builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int whichButton) {
				projectName = null;
				MainActivity.this.getSupportActionBar().setIcon(R.drawable.ic_launcher);
				MainActivity.this.getStartStopButton().toggle();
			}
		});

		builder.show();
	}

	protected CompoundButton getStartStopButton() {
		ToggleButton startStopButton;
		startStopButton = (ToggleButton)MainActivity.this.findViewById(R.id.startStopButton);
		return startStopButton;
	}

	public void stopLocationService() {
    	unbindService(connection);
    }
    
	@Override
	public void locationChanged() {
		float distance = TsisLocationHandler.getDistance();
		double altitude = TsisLocationHandler.getAltitude();
		
		TextView distanceTextView = (TextView) findViewById(R.id.distanceTextView);
		TextView altitudeTextView = (TextView) findViewById(R.id.altitudeTextView);
		
		if(distanceTextView != null) {
			distanceTextView.setText(distance + "m");
		}
		
		if(altitudeTextView != null) {
			altitudeTextView.setText(altitude + "m");
		}
	}
}
