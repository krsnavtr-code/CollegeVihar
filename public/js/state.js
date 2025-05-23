// state data
const statesData = {
    "north region": [
    //     {
    //     name: 'Jammu and Kashmir',
    //     image: "./images/stateImages/Jammu-Kashmir.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-jammu-kashmir-india-260nw-1747045811.jpg'
    // },
    // {
    //     name: 'Himachal Pradesh',
    //     image: "https://lh5.googleusercontent.com/p/AF1QipNNKK_uOOsPEfEYQ7vTp5uAWx12aAt5OzBA_cg=w540-h312-n-k-no",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-himachal-pradesh-india-260nw-1747046024.jpg'
    // },
    {
        name: 'Punjab',
        image: "https://lh5.googleusercontent.com/p/AF1QipMU8xPHOakcdPjjT4bNIiIxuTiv6pQ7DRWxIGfn=w540-h312-n-k-no",
        map: 'https://www.shutterstock.com/image-vector/modern-map-punjab-india-state-260nw-1747079855.jpg'
    },
    // {
    //     name: 'Uttarakhand',
    //     image: "https://lh5.googleusercontent.com/p/AF1QipMCLMBZ4Oa11R0EZ3Uk1eVUdtoG061cy2C8O4Uz=w540-h312-n-k-no",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-uttarakhand-india-state-260nw-1747039889.jpg'
    // },
    {
        name: 'Haryana',
        image: "https://lh5.googleusercontent.com/p/AF1QipMgvEaA59uOASsReL-iSn2kbHBsALjgcEHotNyM=w540-h312-n-k-no",
        map: 'https://www.shutterstock.com/image-vector/modern-map-haryana-india-state-260nw-1747046381.jpg'
    },

    {
        name: 'Uttar Pradesh',
        image: "https://lh5.googleusercontent.com/p/AF1QipOwcynxRpNebAQYvogATP7Bg7j0k45R21LWYlCN=w540-h312-n-k-no",
        map: 'https://www.shutterstock.com/image-vector/modern-map-uttar-pradesh-india-260nw-1747079303.jpg'
    },
    {
        name: 'Chhattisgarh',
        image: "https://specialplacesofindia.com/wp-content/uploads/2023/08/Untitled-design-11-1-1140x660-1-1024x593.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-himachal-pradesh-india-260nw-1747046024.jpg'
    },
    {
        name: 'Madhya Pradesh',
        image: "https://lh5.googleusercontent.com/p/AF1QipPzAEJm6dApb6Mvm5Ij_SUByUzMu2pAXA8euhgB=w540-h312-n-k-no",
        map: 'https://www.shutterstock.com/image-vector/modern-map-madhya-pradesh-india-260nw-1747044968.jpg'
    },
    {
        name: 'Sikkim',
        image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    },
    // {
    //     name: 'Chandigarh',
    //     image: "./images/stateImages/Chandigarh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-chhattisgarh-india-state-260nw-1747047158.jpg'
    // },
    // {
    //     name: 'Delhi',
    //     image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ52vQmpFtpyfcDJlRsC3-JYuCZoS84JDo9dw&s",
    // }
    ],
    // "east region": [
    //     {
    //     name: 'Jharkhand',
    //     image: "https://images.news18.com/ibnlive/uploads/2023/11/jharkhand-foundation-day-2023-2023-11-f588bf656684750e5023c7b5627ae60e-3x2.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-jharkhand-india-state-260nw-1747037177.jpg'
    // },
    // {
    //     name: 'Odisha',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/4/47/Konarka_Temple.jpg/800px-Konarka_Temple.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-orissa-india-state-260nw-1747081058.jpg'
    // },
    // {
    //     name: 'Assam',
    //     image: "https://cdn.britannica.com/51/124451-050-B0B0222D/view-Guwahati-Assam-India.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-assam-india-state-260nw-1747047515.jpg'
    // },
    // {
    //     name: 'Bihar',
    //     image: "https://www.ibef.org/assets/images/states/bihar-2.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-bihar-india-state-260nw-1747047761.jpg'
    // },
    // {
    //     name: 'Arunachal Pradesh',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'Manipur',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'Meghalaya',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'Mizoram',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'Nagaland',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'Sikkim',
    //     image: "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg/1200px-Golden_Pagoda_Namsai_Arunachal_Pradesh.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-arunachal-pradesh-india-260nw-1747048301.jpg'
    // },
    // {
    //     name: 'West Bengal',
    //     image: "https://www.holidify.com/images/tooltipImages/WEST-BENGAL.jpg",
    //     map: 'https://www.shutterstock.com/image-vector/modern-map-west-bengal-india-260nw-1747039589.jpg'
    // }
    // ],
    "west region": [{
        name: 'Maharashtra',
        image: "https://www.fabhotels.com/blog/wp-content/uploads/2019/10/Maharashtra-Tourism_600.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-maharashtra-india-state-260nw-1747044521.jpg'
    },
    {
        name: 'Rajasthan',
        image: "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/15/33/fc/f9/rajasthan.jpg?w=1200&h=700&s=1",
        map: 'https://www.shutterstock.com/image-vector/modern-map-rajasthan-india-state-260nw-1747039076.jpg'
    },
    {
        name: 'Gujarat',
        image: "https://www.eyeonasia.gov.sg/images/india-selected/gujarat-profile.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-gujarat-india-state-260nw-1747046612.jpg'
    },
    // {
    //     name: 'Goa',
    //     image: "https://assets.cntraveller.in/photos/65169715f1f1534fc4e0f24d/4:3/w_1640,h_1230,c_limit/W%20Goa.jpg",
    // },
    {
        name: 'Dadra & Nagar Haveli',
        image: "https://res.cloudinary.com/kmadmin/image/upload/v1556098270/kiomoi/dadra_and_nagar_haveli/Dadar%20Nagr%20Haveli.jpg",
    },
    // {
    //     name: 'Daman & Diu',
    //     image: "https://www.tourmyindia.com/socialimg/daman-diu-tourism.jpg",
    // }
    ],
    "south region": [{
        name: 'Andhra Pradesh',
        image: "https://www.holidify.com/images/bgImages/ANDHRA-PRADESH.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-andhra-pradesh-india-260nw-1747048019.jpg'
    },
    {
        name: 'Karnataka',
        image: "./images/stateImages/Karnataka.jpg",
        map: 'https://www.shutterstock.com/image-vector/modern-map-karnataka-india-state-260nw-1747045565.jpg'
    },
    {
        name: 'Kerala',
        image: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSWLzjr1Bmd5hgfdNBxklkwbwOkRrFLSih71Q&s",
        map: 'https://www.shutterstock.com/image-vector/modern-map-kerala-india-state-260nw-1747045331.jpg'
    },
    {
        name: 'Tamil Nadu',
        image: "https://www.tamilnadutourism.tn.gov.in/img/pages/medium-desktop/heritage-1654930257_3bd4e2db17e0cee92f15.webp",
        map: 'https://www.shutterstock.com/image-vector/modern-map-tamil-nadu-india-260nw-1747038320.jpg'
    },
    {
        name: 'Telangana',
        image: "https://bsmedia.business-standard.com/_media/bs/img/article/2023-09/13/full/1694580750-7848.jpg?im=FeatureCrop,size=(826,465)",
        map: 'https://www.shutterstock.com/image-vector/modern-map-telangana-india-state-260nw-1747079522.jpg'
    },
    // {
    //     name: 'Puducherry',
    //     image: "https://cdn.britannica.com/92/171192-050-6B7A59D9/Matriamandir-Puducherry-Auroville-India.jpg",
    // },
    // {
    //     name: 'Lakshadweep',
    //     image: "https://images.indianexpress.com/2024/02/lakshadweep-island.jpg?w=414",
    // },
    // {
    //     name: 'Andaman & Nicobar Islands',
    //     image: "https://www.tourmyindia.com/blog/wp-content/uploads/2021/09/Best-Places-to-Visit-in-Andaman.jpg",
    // }
    ],
    // international: [{
    //     name: 'Australia',
    //     image: 'https://lh5.googleusercontent.com/p/AF1QipMHftgSCBlvyjxYphi4gLqDC_62WWvZvyy1EBuh=w540-h312-n-k-no'
    // },
    // {
    //     name: 'Canada',
    //     image: 'https://lh5.googleusercontent.com/p/AF1QipNAFPH3KKYh5mQZXazUZ7cG22s9oiHyMKJobDoA=w540-h312-n-k-no'
    // },
    // {
    //     name: 'New Zealand',
    //     image: 'https://encrypted-tbn3.gstatic.com/licensed-image?q=tbn:ANd9GcQvAQHu1P5rx8G7lm-Uv6cI52Mf14w-gTC29pfi2Rw-jAxnWfG7iGtNsWI2QE0A8JSLiJeKg7iUsz7Fn8BZivjaf_jIyJ2SuIWKQ0GIAw'
    // },
    // {
    //     name: 'United States',
    //     image: 'https://lh5.googleusercontent.com/p/AF1QipMYOUyMI0ccgwrx5KEuE_a-5qg8iIXyKoOsFQlI=w540-h312-n-k-no'
    // },
    // {
    //     name: 'United Kingdom',
    //     image: "https://i.natgeofe.com/k/136f063c-7b06-481d-be84-33452d8ff169/united-kingdom-abbey.jpg?wp=1&w=1084.125&h=609"
    // },
    // ]
};

// converting state data into html
function displayStates(statesData) {
    const container = document.getElementById('region-container');
    for (const region in statesData) {
        if (statesData.hasOwnProperty(region)) {
            const regionDiv = document.createElement('div');
            regionDiv.classList.add('region');

            const regionTitle = document.createElement('h4');
            regionTitle.textContent = region.charAt(0).toUpperCase() + region.slice(1);
            regionDiv.appendChild(regionTitle);

            const statesDiv = document.createElement('div');
            statesDiv.classList.add('states');

            statesData[region].forEach(state => {
                const stateDiv = document.createElement('a');
                stateDiv.classList.add('state');
                // stateDiv.href = `/universities/${state.name}`;
                stateDiv.href = `/universities/${encodeURIComponent(state.name)}`;

                const stateName = document.createElement('p');
                stateName.textContent = state.name;
                stateDiv.appendChild(stateName);

                const stateImage = document.createElement('img');
                stateImage.src = state.image;
                stateImage.alt = state.name;
                stateDiv.appendChild(stateImage);

                statesDiv.appendChild(stateDiv);
            });

            regionDiv.appendChild(statesDiv);
            container.appendChild(regionDiv);
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    displayStates(statesData);
});