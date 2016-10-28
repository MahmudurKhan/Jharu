//
//  ViewController.swift
//  Jharu
//
//  Created by Mahmudur Khan on 8/29/15.
//  Copyright (c) 2015 iTechoid. All rights reserved.
//

import UIKit
import CoreLocation

class ViewController: UIViewController, CLLocationManagerDelegate {

    let locationManager = CLLocationManager()
    var lat = String()
    var lon = String()
    var test = String()
    var theValue = 0
    
    override func viewDidLoad() {
        super.viewDidLoad()
        self.locationManager.delegate = self
        self.locationManager.desiredAccuracy = kCLLocationAccuracyBest
        self.locationManager.requestWhenInUseAuthorization()
        self.locationManager.startUpdatingLocation()
        
               // Do any additional setup after loading the view, typically from a nib.
    }
    
    override func viewDidAppear(animated: Bool) {
        if NSUserDefaults.standardUserDefaults().objectForKey("val") == nil{
            theValue = 1
            NSUserDefaults.standardUserDefaults().setObject(theValue, forKey: "val")
            NSUserDefaults.standardUserDefaults().synchronize()
            print("up")
            self.performSegueWithIdentifier("helpOneViewController", sender: self)
        }else
        {
            print("no")
        }
        

    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    func locationManager(manager: CLLocationManager, didUpdateLocations locations: [CLLocation]) {
        lat = String(stringInterpolationSegment: manager.location!.coordinate.latitude)
        lon = String(stringInterpolationSegment:manager.location!.coordinate.longitude)
        print(lat)
        print(lon)
        self.locationManager.stopUpdatingLocation()
    }
    
    
    func locationManager(manager: CLLocationManager, didFailWithError error: NSError) {
        
        print("Error: " + error.localizedDescription)
        
    }

    @IBAction func locationButton(sender: AnyObject) {
        
        sender.setImage(UIImage(named:"waithere.png"),forState:UIControlState.Normal)
      
        let simple = lat+"/"+lon
        print(simple)
        let url = NSURL(string: "http://jharu.itechoid.com/index.php/main/insert_geolocation/"+simple)
        
        let task = NSURLSession.sharedSession().dataTaskWithURL(url!) {(data, response, error) in
           self.test = (NSString(data: data!, encoding: NSUTF8StringEncoding) as! String)
            if (self.test == "1")
            {
                self.performSegueWithIdentifier("successViewController", sender: self)
            }else
            {
                print(self.test)
            }

        }
        task.resume()
        
       
    }

    @IBAction func helpButton(sender: AnyObject) {
        self.performSegueWithIdentifier("helpOneViewController", sender: self)
        
    }
    
    @IBAction func dumpButton(sender: AnyObject) {
        
    }
    
}

