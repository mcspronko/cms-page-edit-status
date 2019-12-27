# TODO

## Document Status for CMS Page
* [Done] Storing Capability:
  * [Done] Create a custom table `pronko_cms_page_status`
  * [Done] Model, Resource Model, Collection for DocumentStatus entity
  * [Done] Store current user session/CMS page information into a custom table
    * [Done] Plugin/Observer to listen a CMS Page Edit page controller and store user data into a table
    * [Done] Document Status Management Service to update/create new Document Status
* Tracking Capability
  * [Done] Track CMS Page open and update/create a record.
  * [In Progress] Track that CMS Page is closed
    * [Done] "Save & Close" button 
    * [Done] Track "Back" button
    * [Done] "Save & Duplicate" button
    * [Advanced] Ping backend with an AJAX request and send current page_id and user_id to be stored/updated in a Document Status table
    * Cron which checks all documents with an "edit" status and update status to "closed"
* [Done] Rendering Capability
  * [Done] Render document status information on a CMS Page Listing page.
    * [Done] Add Status collection class into the StatusProvider class
    * [Done] Check if the status exists
* [Done] John edited the page 10 mins ago.
* Add user collection result caching for UserProvider class 
* Feature - Add CMS Page History DB table in order to track changes on a page. Then the Document Status can show "opened" or "edited" statuses. 
* Refactor DateTime and use Magento Framework DateTime

## Good to have
* Show new CMS Page record in the CMS Page Grid to notify about new page is about to be created.

 
The `pronko_cms_page_status` table schema:
* record_id 
* user_id
* page_id (entity_id)
* status (document_status) - edit (1, 2)
* timestamp/created_at
* updated_at (timestamp)

The `pronko_document_status` table:
* status_id
* code

An user can open more than one page (different tabs).
A page can be abandoned (left open in a browser).

Can we have more than one user who edits same page? - Yes
 - user_id = 1, page_id = 1
 - user_id = 2, page_id = 1