package at.plieschn.tsis;

import java.io.StringWriter;
import java.text.SimpleDateFormat;
import java.util.Locale;
import java.util.Vector;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;
import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerException;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;
import org.w3c.dom.Element;

import android.location.Location;

public class KmlTrack {
	private Vector<Location> trackPoints;
	private String trackName;
	private int trackPart;
	
	public KmlTrack(Vector<Location> locations, String trackName, int trackPart) {
		this.trackPoints = locations;
		this.trackName = trackName;
		this.trackPart = trackPart;
	}
	
	public int getTrackPart() {
		return trackPart;
	}
	
	public String createKml() {
		try {
			DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
			DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
			
			Document doc = docBuilder.newDocument();
			Element kmlRootElement = doc.createElement("kml");
			doc.appendChild(kmlRootElement);
			
			kmlRootElement.setAttribute("xmlns", "http://www.opengis.net/kml/2.2");
			kmlRootElement.setAttribute("xmlns:gx", "http://www.google.com/kml/ext/2.2");
			
			Element documentElement = doc.createElement("Document");
			kmlRootElement.appendChild(documentElement);
			
			Element nameElement = doc.createElement("name");
			nameElement.appendChild(doc.createTextNode(trackName));
			documentElement.appendChild(nameElement);
			
			Element styleElement = doc.createElement("Style");
			styleElement.setAttribute("id", "lineStyle");
			documentElement.appendChild(styleElement);
			
			Element lineStyleElement = doc.createElement("LineStyle");
			styleElement.appendChild(lineStyleElement);
			
			Element colorElement = doc.createElement("color");
			colorElement.appendChild(doc.createTextNode("ff0000ff"));
			lineStyleElement.appendChild(colorElement);
			
			Element widthElement = doc.createElement("width");
			widthElement.appendChild(doc.createTextNode("5"));
			lineStyleElement.appendChild(widthElement);
			
			Element folderElement = doc.createElement("Folder");
			documentElement.appendChild(folderElement);
			
			Element folderNameElement = doc.createElement("name");
			folderNameElement.appendChild(doc.createTextNode(trackName + " part "+trackPart)); //FIXXXME
			folderElement.appendChild(folderNameElement);
			
			Element placemarkElement = doc.createElement("Placemark");
			folderElement.appendChild(placemarkElement);
			
			Element styleUrlElement = doc.createElement("styleUrl");
			styleUrlElement.appendChild(doc.createTextNode("#lineStyle"));
			placemarkElement.appendChild(styleUrlElement);
			
			Element gxTrackElement = doc.createElementNS("http://www.google.com/kml/ext/2.2", "gx:Track");
			gxTrackElement.setAttribute("id", ""+trackPart);
			placemarkElement.appendChild(gxTrackElement);
			
			Element tessellateElement = doc.createElement("tessellate");
			tessellateElement.appendChild(doc.createTextNode("1"));
			gxTrackElement.appendChild(tessellateElement);
			
			for (Location location: trackPoints) {
				Element whenElement = doc.createElement("when");
				String dateString = new SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'", Locale.GERMAN).format(location.getTime());
				whenElement.appendChild(doc.createTextNode(dateString));
				gxTrackElement.appendChild(whenElement);
				
				Element gxCoordElement = doc.createElementNS("http://www.google.com/kml/ext/2.2", "gx:coord");
				StringBuilder coordBuilder = new StringBuilder();
				coordBuilder.append(Double.toString(location.getLatitude()));
				coordBuilder.append(" ");
				coordBuilder.append(Double.toString(location.getLongitude()));
				coordBuilder.append(" ");
				coordBuilder.append(Double.toString(location.getAltitude()));
				gxCoordElement.appendChild(doc.createTextNode(coordBuilder.toString()));
				gxTrackElement.appendChild(gxCoordElement);
			}
			
			TransformerFactory transformFactory = TransformerFactory.newInstance();
			Transformer transformer = transformFactory.newTransformer();
			
			transformer.setOutputProperty(OutputKeys.INDENT, "yes");		
			transformer.setOutputProperty(OutputKeys.OMIT_XML_DECLARATION, "no");
			transformer.setOutputProperty(OutputKeys.VERSION, "1.0");
			transformer.setOutputProperty(OutputKeys.ENCODING, "UTF-8");
			transformer.setOutputProperty(OutputKeys.STANDALONE, "no");

			DOMSource source = new DOMSource(doc);
			
			StringWriter writer = new StringWriter();
			StreamResult result = new StreamResult(writer);
			
			transformer.transform(source, result);
						
			return writer.toString();
			
		} catch (ParserConfigurationException pce) {
			pce.printStackTrace();
		} catch (TransformerException e) {
			e.printStackTrace();
		}
		
		return null;
	}
}
