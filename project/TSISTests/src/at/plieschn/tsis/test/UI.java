package at.plieschn.tsis.test;

import junit.framework.Test;
import junit.framework.TestSuite;

public class UI {

	public static Test suite() {
		TestSuite suite = new TestSuite(UITests.class.getName());
		//$JUnit-BEGIN$
		suite.addTestSuite(UITests.class);
		//$JUnit-END$
		return suite;
	}

}
