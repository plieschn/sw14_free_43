package at.plieschn.android.calculator.test;

import com.robotium.solo.Solo;

import android.test.ActivityInstrumentationTestCase2;
import android.widget.EditText;
import at.plieschn.android.calculator.MainActivity;

public class MainActivityTests extends ActivityInstrumentationTestCase2<MainActivity> {
	private Solo solo;

	@Override
	protected void setUp() throws Exception {
		super.setUp();
		solo = new Solo(getInstrumentation(), getActivity());
	}

	@Override
	protected void tearDown() throws Exception {
		super.tearDown();
	}

	public MainActivityTests() {
		super(MainActivity.class);
	}
	
	public MainActivityTests(Class<MainActivity> activityClass) {
		super(activityClass);
	}

	public void testButtons() {
		for(String text: new String[] {
				"0", "1", "2", "3", "4", "5", "6", "7", "8", "9", 
				"+", "-", "*", "/", 
				"C", "=", "," }) {
			solo.clickOnButton(text);
		}
	}

	public void testInputField() {
		solo.clickOnButton("4");
		solo.clickOnButton("7");
		solo.clickOnButton(",");
		solo.clickOnButton("1");
		solo.getText("47.1");
	}

	public void testInputFieldInvalid() {
		solo.clickOnButton("4");
		solo.clickOnButton("7");
		solo.clickOnButton(",");
		solo.clickOnButton("1");
		solo.clickOnButton(",");
		solo.clickOnButton("2");
		
		solo.getText("47.12");
	}

	public void testAdd() {
		solo.clickOnButton("7");
		solo.clickOnButton("+");
		solo.clickOnButton("4");
		solo.clickOnButton("=");
		solo.getText("11");
	}

	public void testMinus() {
		solo.clickOnButton("7");
		solo.clickOnButton("2");
		solo.clickOnButton("-");
		solo.clickOnButton("4");
		solo.clickOnButton("2");
		solo.clickOnButton("=");
		solo.getText("30");
	}

	public void testMult() {
		solo.clickOnButton("9");
		solo.clickOnButton("*");
		solo.clickOnButton("9");
		solo.clickOnButton("=");
		solo.getText("81");
	}

	public void testDiv() {
		solo.clickOnButton("7");
		solo.clickOnButton("2");
		solo.clickOnButton("/");
		solo.clickOnButton("8");
		solo.clickOnButton("=");
		solo.getText("9");
	}
	
	public void testClear() {
		solo.clickOnButton("1");
		solo.clickOnButton("5");
		solo.clickOnButton(",");
		solo.clickOnButton("3");
		solo.clickOnButton("C");
		assertEquals(((EditText) solo.getView("inputField")).getText().toString(), "");
	}
}
