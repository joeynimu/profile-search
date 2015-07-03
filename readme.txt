How To:

1. Display page
   - Offer search box
   - Offer "People you may know" feature to be displayed if relevant data exists
   - Load data from JSON file
   - Parse JSON data and display clickable user profiles

2. Search: On search, listen for change in text and begin search:
   2.1. User data entry
     - Check if user has made previous searches by checking stored keywords
       - If keywords exist, make suggestions based on that
       - Else, make suggestions based on data in the JSON payload
   
       2.2. If user continues to search and uses search button, search data as per keyword entered and save the keyword.
       2.3. If user clicks on an autosuggested keyword, search data as per the keyword.
   2.4. Display persons with matching info


3. Profile Click:
   - Collect profile keywords()
   - Save keywords() if not already present
   - Show profile
   - Activate / update "People you may know" view

4. Upon further user interaction, repeat the steps above as applicable


sample json for search

  	var json = '{"glossary":{"title":"example glossary","GlossDiv":{"title":"S","GlossList":{"GlossEntry":{"ID":"SGML","SortAs":"SGML","GlossTerm":"Standard Generalized Markup Language","Acronym":"SGML","Abbrev":"ISO 8879:1986","GlossDef":{"para":"A meta-markup language, used to create markup languages such as DocBook.","ID":"44","str":"SGML","GlossSeeAlso":["GML","XML"]},"GlossSee":"markup"}}}}}';

    var searchableJSON = JSON.parse(json);

sample search response

    "RESULT: [{"id":3,"guid":"5a5afc33-32cb-49f6-b497-bfc34ff53ef0","picture":"http://placehold.it/32x32","age":34,"name":"Allison Carey","gender":"male","company":"Ameritron","phone":"851-444-2730","email":"allison@ameritron.com","address":"21796, Downey, Broadway at 88th Street","about":"Luptatum feugiat nulla eum dolor commodo, enim duis facilisis lorem dolore, praesent nonummy illum in. Augue, sed ea luptatum eum quis, sed hendrerit ad veniam laoreet, minim nulla suscipit. Dolore dolore, hendrerit consequat aliquip esse dignissim, ea commodo lobortis luptatum wisi, te wisi. Illum molestie ullamcorper, lobortis ut nibh diam minim, dolore duis magna luptatum nonummy, hendrerit. Iusto dolore dolore molestie, vero feugiat consectetuer qui suscipit, accumsan ipsum adipiscing exerci et, veniam euismod tation blandit eros, consectetuer ex accumsan.","registered":"1991-05-10T18:09:27 -02:00","tags":["eros","luptatum","tation","suscipit","aliquam","odio","feugiat"],"friends":[{"id":1,"name":"Faith Daniels"},{"id":2,"name":"Serenity Wood"},{"id":3,"name":"Ava Vance"}]},{"id":3,"name":"Allison Osborne"},{"id":59,"guid":"a203f867-24c7-4288-aa70-afa8a78c2002","picture":"http://placehold.it/32x32","age":35,"name":"Allison Freeman","gender":"female","company":"Steganoconiche","phone":"803-437-2868","email":"allison@steganoconiche.com","address":"20384, Downey,  nr 43rd Street","about":"Commodo dolore consectetuer iriure ut illum, nonummy dolore praesent ipsum nibh, vel vel dolore enim. Ut, nibh duis zzril duis suscipit, augue ut feugait laoreet hendrerit, commodo duis dignissim. Esse nulla, eu feugiat luptatum ad volutpat, sit zzril facilisi eum dignissim, facilisis in. Eros duis odio, nulla erat erat hendrerit zzril, ullamcorper dignissim luptatum tincidunt wisi, suscipit. Luptatum luptatum sed nulla, dolor aliquam autem.","registered":"2004-09-27T13:14:11 -02:00","tags":["erat","ut","wisi","nulla","ut","dolore","esse"],"friends":[{"id":1,"name":"Payton Cramer"},{"id":2,"name":"Valeria Daniels"},{"id":3,"name":"Hailey Gate"}]},{"id":76,"guid":"18c82fd3-9aa4-4f72-8b9b-51e3c22c0c2e","picture":"http://placehold.it/32x32","age":23,"name":"Allison Gardner","gender":"female","company":"Orthomedia","phone":"826-487-2558","email":"allison@orthomedia.com","address":"35164, Clearwater, Spring Streets","about":"Adipiscing minim ex feugiat nulla facilisi, erat amet suscipit molestie laoreet, eu volutpat in minim. Autem, nonummy delenit ullamcorper qui ex, ex vulputate vero te in, tation dolore praesent. Esse elit, eros elit nibh eu sit, in ex dolore ea magna, nostrud facilisi. Adipiscing duis duis, quis erat dolor nulla dolore, vel eros volutpat ipsum enim, vel. Feugiat in accumsan illum, odio zzril facilisi feugiat consectetuer, lobortis dignissim eum magna consequat, facilisi suscipit vulputate augue dolor, ut suscipit odio exerci consectetuer, veniam velit sed vel. Eu, nulla consequat facilisi ut.","registered":"1996-12-09T23:51:49 -01:00","tags":["laoreet","hendrerit","wisi","iusto","facilisis","elit","esse"],"friends":[{"id":1,"name":"Evelyn Vaughan"},{"id":2,"name":"Paige Clapton"},{"id":3,"name":"Bailey Galbraith"}]},{"id":2,"name":"Allison Brown"},{"id":2,"name":"Allison Creighton"},{"id":1,"name":"Allison Wallace"}]"               
