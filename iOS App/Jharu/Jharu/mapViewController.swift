//
//  mapViewController.swift
//  
//
//  Created by Mahmudur Khan on 9/3/15.
//
//

import UIKit
import MapKit
import CoreLocation


class mapViewController: UIViewController {

    @IBOutlet var mapView: MKMapView!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let location = CLLocationCoordinate2DMake(23.811732, 90.421343)
        let location2 = CLLocationCoordinate2DMake(23.805764, 90.419540)
        let span = MKCoordinateSpanMake(0.02, 0.02)
        let region = MKCoordinateRegion(center: location, span: span)
        mapView.setRegion(region, animated: true)
        
        let annotation = MKPointAnnotation()
        let annotation1 = MKPointAnnotation()
        
        annotation.coordinate = location
        annotation1.coordinate = location2
        
        
        
        mapView.addAnnotation(annotation)
        mapView.addAnnotation(annotation1)

        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
    }
    */

}
