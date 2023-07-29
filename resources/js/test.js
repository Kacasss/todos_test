    const trCollection = document.getElementsByClassName("tr");

    // HTMLCollectionを配列にする
    let trArray = Array.from(trCollection);

    // 1つずつ取り出す
    trArray.forEach(function(tr) {

        tr.addEventListener("click", (e) => {
            e.preventDefault();
            window.location = tr.dataset.href;
        });

    });
