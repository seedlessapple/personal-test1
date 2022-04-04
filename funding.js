const tabs = document.querySelectorAll('[data-tab-target]');
const tabContents = document.querySelectorAll('[data-tab-content]');
const idTabContent = document.getElementById('tab_contents');
const reward = document.getElementById('reward');

tabs.forEach(tab => {
    tab.addEventListener('click',() => {
        tabs.forEach(t => {
            t.classList.remove('active');
        });
        tab.classList.add('active');

        const target = document.querySelector(tab.dataset.tabTarget)
        tabContents.forEach(tabContent => {
            tabContent.classList.remove('active');
            
        });
        if(window.screen.width <=1024){
            if (target.id == 'reward') {
                idTabContent.style.width="0%";
                reward.style.width="100%";
            }else{
                idTabContent.style.width="100%";
            }
        }
        target.classList.add('active')

    })
});