package at.plieschn.tsis.test;

import junit.framework.Test;
import junit.framework.TestSuite;

public class Preferences {

	public static Test suite() {
		TestSuite suite = new TestSuite(Preferences.class.getName());
		//$JUnit-BEGIN$
		suite.addTestSuite(UITests.class);
		//$JUnit-END$
		return suite;
	}

}
