/**
 *  RELOAD TOOLS
 *
 *  Copyright (c) 2003 Oleg Liber, Bill Olivier, Phillip Beauvoir
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 *  Project Management Contact:
 *
 *  Oleg Liber
 *  Bolton Institute of Higher Education
 *  Deane Road
 *  Bolton BL3 5AB
 *  UK
 *
 *  e-mail:   o.liber@bolton.ac.uk
 *
 *
 *  Technical Contact:
 *
 *  Phillip Beauvoir
 *  e-mail:   p.beauvoir@dadabeatnik.com
 *
 *  Web:      http://www.reload.ac.uk
 *
 *  @author Paul Sharples
 *  @version $Id: CPModel.js,v 1.2 2006/07/10 11:55:37 phillipus Exp $
 */

 /*
 * Content Package Player Object Model v2.1.
 * A javascript object model describing/modelling the structure of an IMS content package.
 */ 
function packageModel(){
	this.packageName = "";
	this._defaultOrg = 0;
	this._orgCount = 0;
	this._currentOrg = -1;
	this.showSearch = false;
	this.getPackageTitle = getPackageTitleMethod;	
	this.getNumberOfOrgs = getNumberOfOrgsMethod;
	this.orgArray = organizationsArrayModel;
	this.setCurrentOrg = setCurrentOrgMethod;
	this.changeItem = changeItemMethod;
	this.updateNav = updateNavMethod;
	this.getOrganizationTitles = getOrganizationTitlesMethod;
	this.getHref = getHrefMethod;
	this.getSearchArray = getSearchArrayMethod;
	this.orgArr = new Array();	
}

function getNumberOfOrgsMethod(){
	return this._orgCount;
}

function getPackageTitleMethod(){
	return this.packageName;	
}

function getOrganizationTitlesMethod(){
	var titles = new Array();
	for (x=0; x<this.getNumberOfOrgs();x++){
		titles[x] = this.orgArray(x).organizationName;
	}
	return titles;
}

function setCurrentOrgMethod(index){
	if (index != this._currentOrg){
		this._currentOrg = index;
		this.orgArray(this._currentOrg).navSetUp();
	}
}


function getHrefMethod(item){
	var arrayiIndex = parseInt(item);	
	hrefurl = CPAPI.orgArray(CPAPI._currentOrg).itemArray(arrayiIndex).itemHyper;		
	return hrefurl; 	
}


function changeItemMethod(itemToLaunch){
	if (itemToLaunch != -1 && this.orgArray(this._currentOrg) != null){
		if(this.orgArray(this._currentOrg).itemArray(itemToLaunch).itemHyper != "" && this.orgArray(this._currentOrg).itemArray(itemToLaunch).itemHyper != "javascript:void(0)" && this.orgArray(this._currentOrg).itemArray(itemToLaunch).itemTitle != "* hidden"){
			
			if (this.orgArray(this._currentOrg).itemArray(itemToLaunch).itemHyper != ""){
				this.orgArray(this._currentOrg)._currentItem = itemToLaunch;
				parent.window.frames.text.location.href = this.orgArray(this._currentOrg).itemArray(itemToLaunch).itemHyper;		
			}
			this.updateNav();
			return true;
		}
		return false
	}
	else{
		parent.window.frames.text.location.href = "CPStart.htm";
		this.updateNav();
		return false;
	}
}


function updateNavMethod(){
	if (this.orgArray(this._currentOrg)._navigatableItemCount > 1){
		parent.window.frames.CPFrame.updateTitles(this.orgArray(this._currentOrg).itemArray(this.orgArray(this._currentOrg)._currentItem).itemTitle);
		if (this.orgArray(this._currentOrg)._currentItem <= this.orgArray(this._currentOrg)._firstItem){
			parent.window.frames.CPFrame.disablePrevButton();
		}
		else if (this.orgArray(this._currentOrg)._currentItem >= this.orgArray(this._currentOrg)._lastItem){
			parent.window.frames.CPFrame.disableNextButton();
		}	
		else{
			parent.window.frames.CPFrame.enableBothButtons();
		}
	}
	else{
		if (this.orgArray(this._currentOrg)._navigatableItemCount == 1){
			parent.window.frames.CPFrame.disableBothButtons();
			parent.window.frames.CPFrame.updateTitles(this.orgArray(this._currentOrg).itemArray(this.orgArray(this._currentOrg)._currentItem).itemTitle);
		}
		else{
			parent.window.frames.CPFrame.disableBothButtons();
			parent.window.frames.CPFrame.updateTitles("");
		}		
	}
}


function organizationsArrayModel(index){
	if(index > this._orgCount-1){
		if (index == this._orgCount){
			// then create new one...
			this.orgArr[index] = new singleOrganizationModel();
			this._orgCount = this._orgCount + 1;
			return this.orgArr[index];
		}
		else{
			return "false";

		}
	}
	else{
		// we must be talking about this one so return object..
		return this.orgArr[index];
	}
}

function singleOrganizationModel(){
	this.organizationIdentifier = "";
	this.organizationName= "";
	this._itemCount = 0;
	this._navigatableItemCount = 0;	
	this._currentItem = -1;
	this._firstItem = 0;
	this._lastItem = 0;
	this.navSetUp = navSetUpMethod;
	this.itemArray = itemArrayModel;
	this.itemArr = new Array();
	this.navagatableItemArr = new Array();	
	this.getPrevItem = getPrevItemMethod;
	this.getNextItem = getNextItemMethod;
}

function getSearchArrayMethod(){
	var sItem = new Array();
	var c=0;
	var i;
	for (i=0; i < this.orgArray(this._currentOrg)._itemCount; i++){	
		cTitle = this.orgArray(this._currentOrg).itemArray(i).itemTitle;
		cKeywords = this.orgArray(this._currentOrg).itemArray(i).keyWords
		cComments = this.orgArray(this._currentOrg).itemArray(i).comments
		sItem[c] = new Array(""+ i + "", "", cTitle, cKeywords, cComments);		
		c++;
	}		
	return sItem;
}



function getNextItemMethod(){
	if(this._lastItem != this._currentItem){
		for (p=0; p < this.navagatableItemArr.length; p++){
			if(this.navagatableItemArr[p] == this._currentItem){
				return this.navagatableItemArr[p+1];
			}		
		}
	}
}

function getPrevItemMethod(){
	if(this._firstItem != this._currentItem){
		for (p=0; p < this.navagatableItemArr.length; p++){
			if(this.navagatableItemArr[p] == this._currentItem){				
				return this.navagatableItemArr[p-1];
			}		
		}
	}
}

function itemArrayModel(index){
	if(index > this._itemCount-1){
		if(index == this._itemCount){
			// then create new one...
			this.itemArr[index] = new singleItemModel();
			this._itemCount = this._itemCount + 1;
			return this.itemArr[index];
		}
		else{
			return "false";
		}
	}
	else{
		// we must be talking about this one so return object..
		return this.itemArr[index];
	}	
}

var totalCount = 0;

function singleItemModel(){
	this.itemTitle = "";
	this.itemIdentifier = "";
	this.itemHyper = "";
	this.itemParent = "";
	this.keyWords = "";
	this.comments = "";
	this.numberInAllItems;
}




function navSetUpMethod(){
	var count = 0;
	for (p=0; p < this.itemArr.length; p++){
		if(this.itemArray(p).itemHyper != "" && this.itemArray(p).itemHyper != "javascript:void(0)" && this.itemArray(p).itemTitle != "* hidden"){			
			this.navagatableItemArr[count++] = p;
		}
		this.itemArray(p).numberInAllItems = totalCount;
		totalCount++;
	}

	if (this.navagatableItemArr.length != 0){
		this._firstItem = this.navagatableItemArr[0];
		this._currentItem = this.navagatableItemArr[0];
		this._lastItem = this.navagatableItemArr[this.navagatableItemArr.length-1];		
	}
	this._navigatableItemCount = count;

}

// Create the main Object...
var CPAPI = new packageModel;

/**
    Created by: Michael Synovic
    on: 01/12/2003
    
    This is a Javascript implementation of the Java Hashtable object.
    
    Contructor(s):
     Hashtable()
              Creates a new, empty hashtable
    
    Method(s):
     void clear() 
              Clears this hashtable so that it contains no keys. 
     boolean containsKey(String key) 
              Tests if the specified object is a key in this hashtable. 
     boolean containsValue(Object value) 
              Returns true if this Hashtable maps one or more keys to this value. 
     Object get(String key) 
              Returns the value to which the specified key is mapped in this hashtable. 
     boolean isEmpty() 
              Tests if this hashtable maps no keys to values. 
     Array keys() 
              Returns an array of the keys in this hashtable. 
     void put(String key, Object value) 
              Maps the specified key to the specified value in this hashtable. A NullPointerException is thrown is the key or value is null.
     Object remove(String key) 
              Removes the key (and its corresponding value) from this hashtable. Returns the value of the key that was removed
     int size() 
              Returns the number of keys in this hashtable. 
     String toString() 
              Returns a string representation of this Hashtable object in the form of a set of entries, enclosed in braces and separated by the ASCII characters ", " (comma and space). 
     Array values() 
              Returns a array view of the values contained in this Hashtable. 
            
*/
function Hashtable(){
    this.clear = hashtable_clear;
    this.containsKey = hashtable_containsKey;
    this.containsValue = hashtable_containsValue;
    this.get = hashtable_get;
    this.isEmpty = hashtable_isEmpty;
    this.keys = hashtable_keys;
    this.put = hashtable_put;
    this.remove = hashtable_remove;
    this.size = hashtable_size;
    this.toString = hashtable_toString;
    this.values = hashtable_values;
    this.hashtable = new Array();
}

/*=======Private methods for internal use only========*/

function hashtable_clear(){
    this.hashtable = new Array();
}

function hashtable_containsKey(key){
    var exists = false;
    for (var i in this.hashtable) {
        if (i == key && this.hashtable[i] != null) {
            exists = true;
            break;
        }
    }
    return exists;
}

function hashtable_containsValue(value){
    var contains = false;
    if (value != null) {
        for (var i in this.hashtable) {
            if (this.hashtable[i] == value) {
                contains = true;
                break;
            }
        }
    }
    return contains;
}

function hashtable_get(key){
    return this.hashtable[key];
}

function hashtable_isEmpty(){
    return (parseInt(this.size()) == 0) ? true : false;
}

function hashtable_keys(){
    var keys = new Array();
    var aCount = 0;
    for (var i in this.hashtable) {
        if (this.hashtable[i] != null) 
            //keys.push(i);
            keys[aCount++] = i;
    }
    return keys;
}

function hashtable_put(key, value){
    if (key == null || value == null) {
        throw "NullPointerException {" + key + "},{" + value + "}";
    }else{
        this.hashtable[key] = value;
    }
}

function hashtable_remove(key){
    var rtn = this.hashtable[key];
    this.hashtable[key] = null;
    return rtn;
}

function hashtable_size(){
    var size = 0;
    for (var i in this.hashtable) {
        if (this.hashtable[i] != null) 
            size ++;
    }
    return size;
}

function hashtable_toString(){
    var result = "";
    for (var i in this.hashtable)
    {      
        if (this.hashtable[i] != null) 
            result += "{" + i + "},{" + this.hashtable[i] + "}\n";   
    }
    return result;
}

function hashtable_values(){
    var values = new Array();
    for (var i in this.hashtable) {
        if (this.hashtable[i] != null) 
            values.push(this.hashtable[i]);
    }
    return values;
}
