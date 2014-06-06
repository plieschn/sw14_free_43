package at.plieschn.tsis.test;

import at.plieschn.tsis.MainActivity;
import android.test.ActivityInstrumentationTestCase2;
import android.widget.Button;

import com.robotium.solo.Solo;


public class UITests extends ActivityInstrumentationTestCase2<MainActivity> {
	private Solo solo;
	private Button startStopButton;
	private Button actionSettingsButton;
	
	@Override
	protected void setUp() throws Exception {
		super.setUp();
		solo = new Solo(getInstrumentation(), getActivity());
		startStopButton = (Button) solo.getView(at.plieschn.tsis.R.id.startStopButton);
		actionSettingsButton = (Button) solo.getView(at.plieschn.tsis.R.id.action_settings);
	}

	@Override
	protected void tearDown() throws Exception {
		try {
			solo.finalize();
		} catch (Throwable e) {
			e.printStackTrace();
		}
		super.tearDown();
	}
	
	
	public UITests() {
		super(MainActivity.class);
	}
	
	public UITests(Class<MainActivity> activityClass) {
		super(activityClass);
	}

	public void testStartButton() {
		solo.clickOnToggleButton(startStopButton.getText().toString());
		assertEquals("Is startStopButton activated", true, solo.isToggleButtonChecked(0));
		solo.clickOnToggleButton(startStopButton.getText().toString());
		assertEquals("Is startStopButton deactivated", false, solo.isToggleButtonChecked(0));
	}
	
	public void testPreferences() {
		solo.clickOnButton(actionSettingsButton.getId());
	}
}
