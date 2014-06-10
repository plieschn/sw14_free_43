package at.plieschn.tsis.test;

import java.util.ArrayList;

import android.test.ActivityInstrumentationTestCase2;
import android.view.View;
import android.widget.Button;
import at.plieschn.tsis.MainActivity;

import com.robotium.solo.Condition;
import com.robotium.solo.Solo;

public class PreferencesTests extends ActivityInstrumentationTestCase2<MainActivity> {
	private class OKButtonExists implements Condition {
		private Solo solo;
		
		public OKButtonExists(Solo solo) {
			this.solo = solo;
		}
		
		@Override
		public boolean isSatisfied() {
			Button button = getOKButton();
			return (button != null);
		}
		
		private Button getOKButton() {
			ArrayList<View> views = solo.getViews();
			
			for(View view: views) {
				try {
					Button button = (Button)view;
					if(button.getText().equals("OK")) {
						return button;
					}
				} catch(Exception e) {
					continue;
				}
			}
			return null;
		}
	}
	
	private Solo solo;
	private OKButtonExists okButtonExists;
	
	@Override
	protected void setUp() throws Exception {
		super.setUp();
		solo = new Solo(getInstrumentation(), getActivity());
		okButtonExists = new OKButtonExists(solo);
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

	public PreferencesTests() {
		super(MainActivity.class);
	}
	
	public PreferencesTests(Class<MainActivity> activityClass) {
		super(activityClass);
	}
	
	
	public void testInterval() {
		int line = 1;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "15");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("15"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "15asd");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("15asd is not a valid number!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("15"));
		solo.goBack();

		solo.goBack();
	}

	public void testMaxAccuracy() {
		int line = 2;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "30");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("30"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "30sdf");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("30sdf is not a valid number!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("30"));
		solo.goBack();

		solo.goBack();
	}
	
	public void testMinimumTimeDifference() {
		int line = 3;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "50");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("50"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "blubb60");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("blubb60 is not a valid number!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("50"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "0");
		solo.clickOnButton("OK");
		
		solo.goBack();
	}

	public void testMinimumDistanceDifference() {
		int line = 4;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "25");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("25"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "dfg60");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("dfg60 is not a valid number!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("25"));
		solo.goBack();

		solo.goBack();
	}
	
	public void testHost() {
		int line = 5;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "http://tsis.plieschn.at");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("http://tsis.plieschn.at"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "tsis.plieschn.at");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("tsis.plieschn.at is not a valid URL!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("http://tsis.plieschn.at"));
		solo.goBack();

		solo.goBack();
	}
	
	public void testUsername() {
		int line = 6;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "username");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("username"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("username is empty!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("username"));
		solo.goBack();

		solo.goBack();
	}
	
	public void testPassword() {
		int line = 7;
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "password");
		solo.clickOnButton("OK");

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("password"));
		solo.goBack();

		solo.clickInList(line, 0);
		solo.clearEditText(0);
		solo.enterText(0, "");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("password is empty!");
		}

		solo.clickInList(line, 0);
		assertTrue(solo.searchText("password"));
		solo.goBack();

		solo.goBack();
	}
}
