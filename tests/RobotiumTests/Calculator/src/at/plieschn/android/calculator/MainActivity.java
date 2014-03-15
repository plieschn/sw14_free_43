package at.plieschn.android.calculator;

import java.security.InvalidParameterException;
import java.util.Map;
import java.util.TreeMap;

import android.support.v7.app.ActionBarActivity;
import android.support.v4.app.Fragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;

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
        
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    /**
     * A placeholder fragment containing a simple view.
     */
    public static class PlaceholderFragment extends Fragment {
    	public abstract class InputFieldOperator {
			protected String getInputFieldContent() {
				return inputField.getText().toString();
			}

			protected void setInputFieldContent(String content) {
				inputField.setText(content);
			}
    	}
    	
		public class NumberButtonOnClickListener extends InputFieldOperator implements OnClickListener {
    		@Override
    		public void onClick(View v) {
    			String content = getInputFieldContent();
    			content += getNumberOfClickedButton(v);
    			try {
    				Float.valueOf(content);
        			setInputFieldContent(content);
    			} catch(NumberFormatException e) {
    				
    			}
    		}

			private String getNumberOfClickedButton(View v) {
				switch(v.getId()) {
				case R.id.buttonOne:
					return "1";
				case R.id.buttonTwo:
					return "2";
				case R.id.buttonThree:
					return "3";
				case R.id.buttonFour:
					return "4";
				case R.id.buttonFive:
					return "5";
				case R.id.buttonSix:
					return "6";
				case R.id.buttonSeven:
					return "7";
				case R.id.buttonEight:
					return "8";
				case R.id.buttonNine:
					return "9";
				case R.id.buttonZero:
					return "0";
				case R.id.buttonComma:
					return ".";
				default:
					throw new InvalidParameterException();
				}
			}
		}
    	
    	public class OperatorButtonOnClickListener extends InputFieldOperator implements OnClickListener {
    		@Override
    		public void onClick(View v) {
				switch(v.getId()) {
				case R.id.buttonPlus:
				case R.id.buttonMinus:
				case R.id.buttonMult:
				case R.id.buttonDiv:
					try {
						firstNumber = Float.valueOf(getInputFieldContent());
					} catch(NumberFormatException e) {
						firstNumber = 0;
					}
					operatorView = v;
					setInputFieldContent("");
					break;
				case R.id.buttonEqual:
					float result = 0;
					float secondNumber = 0;
					switch(operatorView.getId()) {
					case R.id.buttonPlus:
						try {
							secondNumber = Float.valueOf(getInputFieldContent());
						} catch (NumberFormatException e) {
							secondNumber = 0;
						}
						
						result = firstNumber + secondNumber;
						setInputFieldContent(String.valueOf(result));
						break;
					case R.id.buttonMinus:
						try {
							secondNumber = Float.valueOf(getInputFieldContent());
						} catch (NumberFormatException e) {
							secondNumber = 0;
						}
						
						result = firstNumber - secondNumber;
						setInputFieldContent(String.valueOf(result));
						break;
					case R.id.buttonMult:
						try {
							secondNumber = Float.valueOf(getInputFieldContent());
						} catch (NumberFormatException e) {
							secondNumber = 1;
						}
						
						result = firstNumber * secondNumber;
						setInputFieldContent(String.valueOf(result));
						break;
					case R.id.buttonDiv:
						try {
							secondNumber = Float.valueOf(getInputFieldContent());
						} catch (NumberFormatException e) {
							secondNumber = 1;
						}
						
						result = firstNumber / secondNumber;
						setInputFieldContent(String.valueOf(result));
						break;
					default:
						throw new InvalidParameterException();
					}
					break;
				case R.id.buttonClear:
					setInputFieldContent("");
					break;
				default:
					throw new InvalidParameterException();
				}
    			
    		}
    	}

    	private Map<String, Button> numberButtons;
    	private Map<String, Button> operatorButtons;
    	private EditText inputField;
    	
    	private NumberButtonOnClickListener numberButtonOnClickListener;
    	private OperatorButtonOnClickListener operatorButtonOnClickListener;
    	
    	private float firstNumber;
    	private View operatorView;
    	
        public PlaceholderFragment() {
        }

        @Override
        public View onCreateView(LayoutInflater inflater, ViewGroup container,
                Bundle savedInstanceState) {
            View rootView = inflater.inflate(R.layout.fragment_main, container, false);
            return rootView;
        }

        @Override
		public void onActivityCreated(Bundle savedInstanceState) {
			super.onActivityCreated(savedInstanceState);
            numberButtons = new TreeMap<String, Button>();
            numberButtons.put("1", (Button)getActivity().findViewById(R.id.buttonOne));
            numberButtons.put("2", (Button)getActivity().findViewById(R.id.buttonTwo));
            numberButtons.put("3", (Button)getActivity().findViewById(R.id.buttonThree));
            numberButtons.put("4", (Button)getActivity().findViewById(R.id.buttonFour));
            numberButtons.put("5", (Button)getActivity().findViewById(R.id.buttonFive));
            numberButtons.put("6", (Button)getActivity().findViewById(R.id.buttonSix));
            numberButtons.put("7", (Button)getActivity().findViewById(R.id.buttonSeven));
            numberButtons.put("8", (Button)getActivity().findViewById(R.id.buttonEight));
            numberButtons.put("9", (Button)getActivity().findViewById(R.id.buttonNine));
            numberButtons.put("0", (Button)getActivity().findViewById(R.id.buttonZero));
            numberButtons.put(".", (Button)getActivity().findViewById(R.id.buttonComma));

            operatorButtons = new TreeMap<String, Button>();
            operatorButtons.put("+", (Button)getActivity().findViewById(R.id.buttonPlus));
            operatorButtons.put("-", (Button)getActivity().findViewById(R.id.buttonMinus));
            operatorButtons.put("*", (Button)getActivity().findViewById(R.id.buttonMult));
            operatorButtons.put("/", (Button)getActivity().findViewById(R.id.buttonDiv));
            operatorButtons.put("C", (Button)getActivity().findViewById(R.id.buttonClear));
            operatorButtons.put("=", (Button)getActivity().findViewById(R.id.buttonEqual));
            
            inputField = (EditText)getActivity().findViewById(R.id.inputField);
            inputField.setEnabled(false);
            
            numberButtonOnClickListener = new NumberButtonOnClickListener();
            operatorButtonOnClickListener = new OperatorButtonOnClickListener();
            
            for(Button numberButton: numberButtons.values()) {
            	numberButton.setOnClickListener(numberButtonOnClickListener);
            }

            for(Button operatorButton: operatorButtons.values()) {
            	operatorButton.setOnClickListener(operatorButtonOnClickListener);
            }
        }
    }

}
