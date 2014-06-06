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
	
	
	public void testPreferences() {
		solo.clickOnActionBarItem(at.plieschn.tsis.R.id.action_settings);
		
		solo.clickInList(0);
		solo.clearEditText(0);
		solo.enterText(0, "15");
		solo.clickOnButton("OK");

		solo.clickInList(0);
		solo.searchText("15");
		solo.goBack();

		solo.clickInList(0);
		solo.clearEditText(0);
		solo.enterText(0, "15asd");
		solo.clickOnButton("OK");

		if (solo.waitForCondition(okButtonExists, 2000)) {
		    solo.clickOnButton("OK");
		} else {
			fail("15asd is not a valid number!");
		}
		
		solo.goBack();
	}

}
