package at.plieschn.tsis;

import java.net.MalformedURLException;
import java.net.URL;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.preference.Preference;
import android.preference.PreferenceActivity;

public class PreferencesActivity extends PreferenceActivity  {
    @SuppressWarnings("deprecation")
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        addPreferencesFromResource(R.xml.preferences);
        
		findPreference("upload_interval").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
			
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						try {
							Integer.parseInt((String) newValue);
							return true;
						} catch(NumberFormatException e) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.upload_interval_not_numeric_title)
								.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
									@Override
									public void onClick(DialogInterface dialog, int which) {

									}
								});
							builder.create().show();
							
							return false;
						}
					}
		});
        
		findPreference("max_accuracy").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
			
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						try {
							Float.parseFloat((String) newValue);
							return true;
						} catch(NumberFormatException e) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.max_accuracy_not_numeric_title)
								.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
									@Override
									public void onClick(DialogInterface dialog, int which) {

									}
								});
							builder.create().show();
							
							return false;
						}
					}
		});

		findPreference("minimum_time_difference").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
			
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						try {
							Integer.parseInt((String) newValue);
							return true;
						} catch(NumberFormatException e) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.minimum_time_difference_not_numeric_title)
								.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
									@Override
									public void onClick(DialogInterface dialog, int which) {

									}
								});
							builder.create().show();
							
							return false;
						}
					}
		});

		findPreference("minimum_distance_difference").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
			
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						try {
							Integer.parseInt((String) newValue);
							return true;
						} catch(NumberFormatException e) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.minimum_distance_difference_not_numeric_title)
								.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
									@Override
									public void onClick(DialogInterface dialog, int which) {

									}
								});
							builder.create().show();
							
							return false;
						}
					}
		});

		findPreference("host").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
			
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						try {
							new URL((String) newValue);
							return true;
						} catch(MalformedURLException e) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.host_not_url_title)
								.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
									@Override
									public void onClick(DialogInterface dialog, int which) {

									}
								});
							builder.create().show();
							
							return false;
						}
					}
		});

		findPreference("username").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
					
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						if(((String) newValue).length() <= 0) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.username_required_title)
							.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
								@Override
								public void onClick(DialogInterface dialog, int which) {
	
								}
							});
							builder.create().show();
							
							return false;
						} else {
							return true;
						}
					}
		});

		findPreference("password").setOnPreferenceChangeListener(
				new Preference.OnPreferenceChangeListener() {
					
					@Override
					public boolean onPreferenceChange(Preference preference, Object newValue) {
						if(((String) newValue).length() <= 0) {
							AlertDialog.Builder builder = new AlertDialog.Builder(PreferencesActivity.this);
							builder.setMessage(R.string.password_required_title)
							.setNeutralButton(R.string.ok, new DialogInterface.OnClickListener() {
								@Override
								public void onClick(DialogInterface dialog, int which) {
	
								}
							});
							builder.create().show();
							
							return false;
						} else {
							return true;
						}
					}
		});
		
    }
}
