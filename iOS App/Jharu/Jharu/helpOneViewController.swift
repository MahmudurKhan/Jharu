//
//  helpOneViewController.swift
//  
//
//  Created by Mahmudur Khan on 9/3/15.
//
//

import UIKit
import CoreLocation

class helpOneViewController: UIViewController, CLLocationManagerDelegate {

    let locationManager = CLLocationManager()
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view.
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    @IBAction func allowButton(sender: UIButton) {
        self.locationManager.delegate = self
        self.locationManager.desiredAccuracy = kCLLocationAccuracyBest
        self.locationManager.requestWhenInUseAuthorization()
        self.locationManager.startUpdatingLocation()
        self.performSegueWithIdentifier("helpTwoViewController", sender: self)
    }
   
   
  
}
