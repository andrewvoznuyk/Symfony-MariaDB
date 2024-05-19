import React, { useEffect, useState } from "react";
import axios from "axios";
import "../../assets/css/main.css";
import {useNavigate} from "react-router-dom";

const HomeBack = () => {
    const [products, setProducts] = useState([]);
    const [sortConfig, setSortConfig] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage, setItemsPerPage] = useState(20);
    const [totalProductsCount, setTotalProductsCount] = useState(0);
    const [disableNext, setDisableNext] = useState(false);
    const totalPages = Math.ceil(totalProductsCount / itemsPerPage);
    const [filters, setFilters] = useState({
        id: '',
        code: '',
        productName: '',
        price: '',
        'type.typeName': ''
    });
    const navigate = useNavigate();

    const fetchData = async () => {
        try {
            const url = generateUrl();
            const response = await axios.get(url);
            setProducts(response.data);
            setTotalProductsCount(Number(response.headers['x-total-count']));
            const newTotalPages = Math.ceil(response.headers['x-total-count'] / itemsPerPage);
            if (currentPage > newTotalPages) {
                setCurrentPage(newTotalPages);
            }
            setDisableNext(response.data.length < itemsPerPage);
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    };

    const generateUrl = () => {
        const params = new URLSearchParams();
        Object.entries(filters).forEach(([key, value]) => {
            if (value) {
                params.append(key, value);
            }
        });
        if (sortConfig) {
            params.append(`order[${sortConfig.key}]`, sortConfig.direction);
        }
        return `https://courselab.com/api/products?page=${currentPage}&itemsPerPage=${itemsPerPage}&${params.toString()}`;
    };

    const handleSort = (field, event) => {
        if (event && event.target.tagName !== "TH") {
            return;
        }
        let direction = 'asc';
        if (sortConfig && sortConfig.key === field && sortConfig.direction === 'asc') {
            direction = 'desc';
        }
        setSortConfig({ key: field, direction: direction });
    };

    const handleFilterChange = (field, value) => {
        setFilters({ ...filters, [field]: value });
    };

    const onPageChange = (page) => {
        setCurrentPage(page);
    };

    useEffect(() => {
        fetchData();
    }, [filters, sortConfig, currentPage, itemsPerPage]);

    const productInfoHandler = () => {
        navigate("/product-info");
    }

    return (
        <>
            <div className="container">
                <button onClick={productInfoHandler}>Info</button>
                <h1>Products Table</h1>
                <table className="products-table">
                    <thead>
                    <tr>
                        <th onClick={() => handleSort('id')}>
                            ID {sortConfig && sortConfig.key === 'id' && (sortConfig.direction === 'asc' ? '↑' : '↓')}
                        </th>
                        <th onClick={(e) => handleSort('code', e)}>
                            Code {sortConfig && sortConfig.key === 'code' && (sortConfig.direction === 'asc' ? '↑' : '↓')}
                            <input type="text" value={filters.code}
                                   onChange={(e) => handleFilterChange('code', e.target.value)}/>
                        </th>
                        <th onClick={(e) => handleSort('productName', e)}>
                            Name {sortConfig && sortConfig.key === 'productName' && (sortConfig.direction === 'asc' ? '↑' : '↓')}
                            <input type="text" value={filters.productName}
                                   onChange={(e) => handleFilterChange('productName', e.target.value)}/>
                        </th>
                        <th onClick={(e) => handleSort('price', e)}>
                            Price {sortConfig && sortConfig.key === 'price' && (sortConfig.direction === 'asc' ? '↑' : '↓')}
                            <input type="text" value={filters.price}
                                   onChange={(e) => handleFilterChange('price', e.target.value)}/>
                        </th>
                        <th onClick={(e) => handleSort('type.typeName', e)}>
                            Type {sortConfig && sortConfig.key === 'typeName' && (sortConfig.direction === 'asc' ? '↑' : '↓')}
                            <input type="text" value={filters.typeName}
                                   onChange={(e) => handleFilterChange('type.typeName', e.target.value)}/>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {products.map((product) => (
                        <tr key={product.id}>
                            <td>{product.id}</td>
                            <td>{product.code}</td>
                            <td>{product.productName}</td>
                            <td>{product.price}</td>
                            <td style={{color: product.type?.typeName ? 'inherit' : 'red'}}>{product.type?.typeName || 'N/A'}</td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                <div className="pagination">
                    <button onClick={() => onPageChange(currentPage - 1)} disabled={currentPage === 1}>Previous</button>
                    {Array.from({length: totalPages}, (_, i) => (
                        <button key={i + 1} onClick={() => onPageChange(i + 1)}>{i + 1}</button>
                    ))}
                    <button onClick={() => onPageChange(currentPage + 1)}
                            disabled={disableNext || currentPage === totalPages}>Next
                    </button>
                </div>
            </div>
        </>
    );
};

export default HomeBack;
