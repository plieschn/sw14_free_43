package at.plieschn.tsis;

import android.support.v7.app.ActionBarActivity;
import android.support.v4.app.Fragment;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.ToggleButton;

public class MainActivity extends ActionBarActivity {
	
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
    	private TsisLocationHandler locationHandler;
    	
    	@Override
		public void onActivityCreated(Bundle savedInstanceState) {
			super.onActivityCreated(savedInstanceState);
    		startStopButton = (ToggleButton)getActivity().findViewById(R.id.startStopButton);
    		startStopButton.setOnClickListener(this);
    		
    		locationHandler = new TsisLocationHandler((MainActivity)getActivity());
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
					locationHandler.startLocationTracking();
				} else {
					activity.getSupportActionBar().setIcon(R.drawable.ic_launcher);
					locationHandler.stopLocationTracking();
				}
			}
		}
    }
}
