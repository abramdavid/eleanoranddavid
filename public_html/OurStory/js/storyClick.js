function storyClick(clicked_id) {
    if (clicked_id == "first-date-button") {
        var story_text = "David and Ellie met through Bumble.  Ellie sent David a message, asking, \"What sort of musician are you?\"  David replied, \"I play a mean recorder.\"  He then asked Ellie if she would like to have a drink with him at <a href=\"https://www.mercurynews.com/wp-content/uploads/2017/06/26_eastwest_02_gr_.jpg?w=620\" target=\"_blank\">Antonio's Nut House</a>, a bar that might be accurately described as a \"gross college cafeteria\" with \"terrible service\", but was a favorite among graduate students because it had free peanuts.  Ellie said, \"Sure,\" and then she showed up late (from another date) and in overalls.  It may have been David's first date since the recent end of his seven-year relationship, but he was pretty confident that telling Ellie about this relationship would win her over.  He was right.  He sealed the deal with the right jukebox song (not Ring of Fire) and <a href=\"https://www.youtube.com/watch?v=Ue0UpQBmA5s&start=47&end=107\" target=\"_blank\">some irresistible moves</a>.  Both David and Ellie walked away from that night knowing they had met their match.";
    }
    else {
        var story_text = "On their one-year anniversary, David and Ellie finally had enough furnishings in their new apartment to be able to cook, so David made Ellie bibimbap for dinner. Afterwards, David invited Ellie outside onto their deck, which was lit up with string lights (that Ellie had put up), where he asked her to marry him.";
    }
    document.getElementById("story_text").innerHTML = story_text;
    document.getElementById("ourstory-article").style.display = "block";
}

cheet('↑ ↑ ↓ ↓ ← → ← → b a', function () {
    document.getElementById("ourstory-bg").style.backgroundImage = "url(img/contra.jpg)";
    
    alert("Cheat mode enabled - 30 Lives!!!")
});