import React, { useEffect, useState } from "react";
import axios from "axios";
import "../../assets/css/main.css";
import { useNavigate } from "react-router-dom";

const ProductType = () => {
    const [productTypes, setProductTypes] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const url = "https://courselab.com/api/productStats";
            const response = await axios.get(url);
            setProductTypes(response.data);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    const formatPrice = (price) => {
        return price !== undefined ? parseFloat(price).toFixed(2) : "0.00";
    };

    return (
        <>
            <div className="container">
                <button onClick={() => navigate("/")}>Go Back</button>
                <h1>Grouped Product Types</h1>
                <div className="product-type-list">
                    {productTypes.map((group, index) => (
                        <div key={index} className="product-group">
                            <h2>
                                Code: {group.code} ({group.totalCodeItems} Products, Total Price: ${formatPrice(group.totalCodePrice)})
                            </h2>
                            {Object.entries(group.types).map(([type, details], innerIndex) => (
                                <div key={innerIndex} className="product-type-item">
                                    <h3>{type}</h3>
                                    <p>Total Items: {details.TotalItems}</p>
                                    <p>Total Price: ${formatPrice(details.TotalPrice)}</p>
                                </div>
                            ))}
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
};

export default ProductType;
